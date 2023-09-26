<?php

namespace App\Http\Controllers\Api;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\NoteType\CommonNote;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactStoreRequest;
use App\Services\TokenActionService;

class ContactController extends Controller
{
    public function __invoke(ContactStoreRequest $request, TokenActionService $service)
    {
        $apiClient = $service->apiClient();

        $contact = new ContactModel();

        $contact->setName($request->input('name'));

        $customFieldsValuesCollection = new CustomFieldsValuesCollection();

        $phoneField = (new MultitextCustomFieldValuesModel())->setFieldCode('PHONE');
        $multitextCustomFieldValueCollection = new MultitextCustomFieldValueCollection();
        $multitextCustomFieldModel = new MultitextCustomFieldValueModel();
        $multitextCustomFieldModel->setValue($request->input('phone'))
            ->setEnum('WORK');
        $multitextCustomFieldValueCollection->add($multitextCustomFieldModel);

        $phoneField->setValues($multitextCustomFieldValueCollection);
        $customFieldsValuesCollection->add($phoneField);

        $contact->setCustomFieldsValues($customFieldsValuesCollection);


        $lead = $apiClient->leads()->getOne($request->input('leadID'));

        $links = new LinksCollection();

        $links->add($lead);

        try {
            $contact = $apiClient->contacts()->addOne($contact);

            $apiClient->contacts()->link($contact, $links);


            $notesService = $apiClient->notes(EntityTypesInterface::CONTACTS);

            $note = new CommonNote();
            $note->setEntityId($contact->getId())
                ->setText($request->input('text'));

            $notesService->addOne($note);

            return response()->json([
                'message' => 'success'
            ]);

        } catch (AmoCRMApiException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
