<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Email;
use App\Models\Phone;
use App\Models\Supplier;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SupplierService
{

    /**
     * Store a newly created resource in storage.
     */
    public function store($validated) : Supplier
    {        
        $item = DB::transaction(function () use ($validated) {

            $item = new Supplier();
            $item->fill(Arr::except($validated, ['addresses']));
            $item->save();

            $addresses = [];
            foreach($validated['addresses'] as $address){
                $zipcode = preg_replace('/[^0-9]/', '', $address['zipcode']);                
                $addresses[] = array_merge($address, [
                    'supplier_id' => $item->id,
                    'zipcode' => $zipcode
                ]);
            }

            $phones = [];
            $emails = [];
            foreach($validated['contacts'] as $index => $contact){

                $contactData = Arr::except($contact, ['phones', 'emails']);
                $contactData['supplier_id'] = $item->id;
                $contactData['order'] = $index;

                $newContact = new Contact();
                $newContact->fill($contactData);
                $newContact->save();

                foreach($contact['emails'] as $email){
                    if($email['email']){
                        $emails[] = array_merge($email, [
                            'contact_id' => $newContact->id,
                        ]);
                    }
                }

                foreach($contact['phones'] as $phone){
                    if($phone['phone_number']){
                        $phones[] = array_merge($phone, [
                            'contact_id' => $newContact->id,
                        ]);
                    }
                }                
            }

            Address::upsert($addresses, uniqueBy: ['id']);
            Phone::upsert($phones, uniqueBy: ['id']);
            if(!empty($emails)) Email::upsert($emails, uniqueBy: ['id']);

            return $item;
        });
        
        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($validated, Supplier $item) : Supplier
    {
        $item = DB::transaction(function () use ($validated, $item) {            

            $item->update($validated);
            $contactsId = $item->contacts()->get()->pluck('id')->toArray();

            $addresses = [];
            foreach($validated['addresses']  as $address){
                $zipcode = preg_replace('/[^0-9]/', '', $address['zipcode']);                
                $addresses[] = array_merge($address, [
                    'supplier_id' => $item->id,
                    'zipcode' => $zipcode
                ]);
            }

            $contactsRemainingId = [];
            $newPhones = [];
            $phones = [];
            $phonesRemainingId = [];
            $newEmails = [];
            $emails = [];
            $emailsRemainingId = [];
            foreach($validated['contacts'] as $index => $contact){

                $contactData = Arr::except($contact, ['phones', 'emails']);
                $contactData['supplier_id'] = $item->id;
                $contactData['order'] = $index;

                $newContact = new Contact();
                if(isset($contactData['id']) && $contactData['id']){
                    $contactsRemainingId[] = $contactData['id'];
                    $newContact = Contact::find($contactData['id']);
                }

                $newContact->fill($contactData);
                $newContact->save();

                foreach($contact['emails'] as $email){
                    $emailData = array_merge($email, ['contact_id' => $newContact->id]);
                    if(isset($email['id']) && $email['id']){
                        $emails[] = $emailData;
                        $emailsRemainingId[] = $email['id'];
                    }else{
                        $newEmails[] = $emailData;
                    }
                }

                foreach($contact['phones'] as $phone){
                    $phoneData = array_merge($phone, ['contact_id' => $newContact->id]);
                    if(isset($phone['id']) && $phone['id']){
                        $phones[] = $phoneData;
                        $phonesRemainingId[] = $phone['id'];
                    }else{
                        $newPhones[] = $phoneData;
                    }
                }
            }

            Address::upsert($addresses, uniqueBy: ['id']);                        

            // Remove Phones, Emails and Contacts
            $phonesId = Phone::whereIn('contact_id', $contactsId)->get()->pluck('id')->toArray();
            $phonesDeleteId = array_diff($phonesId, $phonesRemainingId);
            if(!empty($phonesDeleteId)) Phone::whereIn('id', $phonesDeleteId)->delete();

            $emailsId = Email::whereIn('contact_id', $contactsId)->get()->pluck('id')->toArray();
            $emailsDeleteId = array_diff($emailsId, $emailsRemainingId);
            if(!empty($emailsDeleteId)) Email::whereIn('id', $emailsDeleteId)->delete();

            $contactsDeleteId = array_diff($contactsId, $contactsRemainingId);
            if(!empty($contactsDeleteId)) Contact::whereIn('id', $contactsDeleteId)->delete();

            //Update Phones and Emails            
            Phone::upsert($phones, uniqueBy: ['id']);
            if(!empty($newPhones)) Phone::upsert($newPhones, uniqueBy: ['id']);

            if(!empty($emails)) Email::upsert($emails, uniqueBy: ['id']);
            if(!empty($newEmails)) Email::upsert($newEmails, uniqueBy: ['id']);

            return $item;
        });

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $item)
    {
        DB::transaction(function () use ($item) {            
            $contactsId = $item->contacts()->get()->pluck('id')->toArray();
            Phone::whereIn('contact_id', $contactsId)->delete();
            Email::whereIn('contact_id', $contactsId)->delete();
            $item->contacts()->delete();
            $item->addresses()->delete();
            $item->delete();
        });
    }

}
