<?php
/**
 * Created by PhpStorm.
 * User: admin-chen
 * Date: 14-5-19
 * Time: 下午6:31
 */

class Filters_InvoiceFilter extends Filters_BaseFilter
{
    public function filter()
    {
        $error_message = ProfessionErrorCodeEnum::getErrorMessage();
        $rules = array(
            'invoice_header' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'contact' => 'required',
            'telephone' => 'required|mobilephone',
        );
        $messages = array(
            'invoice_header.required' => $error_message[ProfessionErrorCodeEnum::ERROR_INVOICE_HEADER_EMPTY],
            'address.required' => $error_message[ProfessionErrorCodeEnum::ERROR_INVOICE_ADDRESS_EMPTY],
            'zip_code.required' => $error_message[ProfessionErrorCodeEnum::ERROR_INVOICE_ZIP_CODE_EMPTY],
            'contact.required' => $error_message[ProfessionErrorCodeEnum::ERROR_INVOICE_CONTACT_EMPTY],
            'telephone.required' => $error_message[ProfessionErrorCodeEnum::ERROR_INVOICE_PHONE_EMPTY],
            'telephone.mobilephone' => $error_message[ProfessionErrorCodeEnum::ERROR_INVOICE_PHONE_FORMAT],
        );
        $this->valid($rules,$messages);
    }
} 