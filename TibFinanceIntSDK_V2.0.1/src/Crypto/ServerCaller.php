<?php

namespace TibFinanceSDK;

require("TibCrypto.php");

/**
 * ServerCall is a class who implemet all TIB FINANCE API methods
 */
class ServerCaller
{
    private $tibCrypto;

    public function __construct($url, $serviceId, $merchantId, $clientId, $userName, $password)
    {
        $this->tibCrypto = new TibCrypto($url, $serviceId, $merchantId, $clientId, $userName, $password);
    }

    // Customer Methods
    /**
     * Create a customer
     * @param string $customerName
     * @param string $customerExternalId
     * @param string $language
     * @param string $customerDescription
     *
     * @return json
     */
    public function createCustomer($customerName, $customerExternalId, $language, $customerDescription)
    {
        $methodName = "/Data/CreateCustomer";

        $data = ["Customer" => [
                                    "CustomerName" => $customerName,
                                    "CustomerExternalId" => $customerExternalId,
                                    "Language" => $language,
                                    "CustomerDescription" => $customerDescription
                                ]
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * List of customers
     * @param string $serviceId
     *
     * @return json
     */
    public function listCustomers($serviceId)
    {
        $methodName = "/Data/ListCustomers";

        $data = ["ServiceId" => $serviceId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get customer by id
     * @param string $customerId
     *
     * @return json
     */
    public function getCustomer($customerId)
    {
        $methodName = "/Data/GetCustomer";

        $data = ["CustomerId" => $customerId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get customer by External Id
     * @param string $externalCustomerId
     *
     * @return json
     */
    public function getCustomersByExternalId($externalCustomerId)
    {
        $methodName = "/Data/GetCustomersByExternalId";

        $data = ["ExternalCustomerId" => $externalCustomerId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * save Customer
     * @param string $customerId
     * @param string $customerName
     * @param string $customerExternalId
     * @param string $language
     * @param string $customerDescription
     *
     * @return json
     */
    public function saveCustomer($customerId, $customerName, $customerExternalId, $language, $customerDescription)
    {
        $methodName = "/Data/SaveCustomer";

        $data = ["Customer" => ["CustomerId" => $customerId,
                                "CustomerName" => $customerName,
                                "CustomerExternalId" => $customerExternalId,
                                "Language" => $language,
                                "CustomerDescription" => $customerDescription]
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * delete Customer
     * @param string $customerId
     *
     * @return json
     */
    public function deleteCustomer($customerId)
    {
        $methodName = "/Data/DeleteCustomer";

        $data = ["CustomerId" => $customerId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    // Payment methods
    /**
     * create Direct Account Payment Method
     * @param string $customerId
     * @param boolean $isCustomerAutomaticPaymentMethod
     * @param array $payementObj
     * @param string $type
     *
     * @return json
     */
    public function createDirectAccountPaymentMethod(
        $customerId,
        $isCustomerAutomaticPaymentMethod,
        $payementObj,
        $type
    ) {
        $types = ["Account" => "Account", "CreditCard" => "CreditCard", "Interac" => "InteracInformation"];
        $methodNames = ["Acount" => "/Data/CreateDirectAccountPaymentMethod",
                        "CreditCard" => "/Data/CreateCreditCardPaymentMethod",
                        "Interac" => "/Data/CreateInteracPaymentMethod"
                       ];

        $data = [
                    "CustomerId" => $customerId,
                    "IsCustomerAutomaticPaymentMethod" => $isCustomerAutomaticPaymentMethod,
                    $types[$type] => $payementObj
                ];

        return $this->tibCrypto->performCall($methodNames[$type], $data);
    }

    /**
     * get Payment Method by Id
     * @param string $paymentMethodId
     *
     * @return json
     */
    public function getPaymentMethod($paymentMethodId)
    {
        $methodName = "/Data/GetPaymentMethod";

        $data = ["PaymentMethodId" => $paymentMethodId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get Customer Payment Method list
     * @param string $customerId
     *
     * @return json
     */
    public function listPaymentMethods($customerId)
    {
        $methodName = "/Data/ListPaymentMethods";

        $data = ["CustomerId" => $customerId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * set default payment method for a customer
     * @param string $paymentMethodId
     * @param string $customerId
     *
     * @return json
     */
    public function setDefaultPaymentMethod($paymentMethodId, $customerId)
    {
        $methodName = "/Data/SetDefaultPaymentMethod";

        $data = ["PaymentMethodId" => $paymentMethodId, "CustomerId" => $customerId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * delete payment method
     * @param string $paymentMethodId
     *
     * @return json
     */
    public function deletePaymentMethod($paymentMethodId)
    {
        $methodName = "/Data/deletePaymentMethod";

        $data = ["PaymentMethodId" => $paymentMethodId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    // Bills / Payments / Transfers
    /**
     * Create Bill
     * @param boolean $breakIfMerchantNeverBeenAuthorized
     * @param array $billData
     *
     * @return json
     */
    public function createBill($breakIfMerchantNeverBeenAuthorized, $billData)
    {
        $methodName = "/Data/CreateBill";

        $data = [
                    "BreakIfMerchantNeverBeenAuthorized" => $breakIfMerchantNeverBeenAuthorized,
                    "BillData" => $billData
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * List Bills
     * @param string $merchantId
     * @param datetime $fromDateTime
     * @param datetime $toDateTime
     *
     * @return json
     */
    public function listBills($merchantId, $fromDateTime, $toDateTime)
    {
        $methodName = "/Data/ListBills";

        $data = [
                    "MerchantId" => $merchantId,
                    "FromDateTime" => $fromDateTime,
                    "ToDateTime" => $toDateTime
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Get Bill by id
     * @param string $billId
     *
     * @return json
     */
    public function getBill($billId)
    {
        $methodName = "/Data/GetBill";

        $data = ["BillId" => $billId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Delete Bill
     * @param string $billId
     *
     * @return json
     */
    public function deleteBill($billId)
    {
        $methodName = "/Data/DeleteBill";

        $data = ["BillId" => $billId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create Payment
     * @param string $billId
     * @param boolean $setPaymentCustomerFromBill
     * @param array $paymentInfo
     *
     * @return json
     */
    public function createPayement($billId, $setPaymentCustomerFromBill, $paymentInfo)
    {
        $methodName = "/Data/DeleteBill";

        $data = [
                    "BillId" => $billId,
                    "SetPaymentCustomerFromBill" => $setPaymentCustomerFromBill,
                    "PaymentInfo" => $paymentInfo
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create Direct Deposit
     * @param string $originMerchantId
     * @param array $destinationAccount
     * @param date $depositDueDate
     * @param int $currency
     * @param int $language
     * @param double $amount
     * @param string $referenceNumber
     *
     * @return json
     */
    public function createDirectDeposit(
        $originMerchantId,
        $destinationAccount,
        $depositDueDate,
        $currency,
        $language,
        $amount,
        $referenceNumber
    ) {
        $methodName = "/Data/CreateDirectDeposit";

        $data = [
                    "OriginMerchantId" => $originMerchantId,
                    "DestinationAccount" => $destinationAccount,
                    "DepositDueDate" => $depositDueDate,
                    "Currency" => $currency,
                    "Language" => $language,
                    "Amount" => $amount,
                    "ReferenceNumber" => $referenceNumber
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create Direct Interac Transaction
     * @param string $originMerchantId
     * @param array $interacInformation
     * @param date $depositDueDate
     * @param int $currency
     * @param int $language
     * @param double $amount
     * @param string $referenceNumber
     *
     * @return json
     */
    public function createDirectInteracTransaction(
        $originMerchantId,
        $interacInformation,
        $depositDueDate,
        $currency,
        $language,
        $amount,
        $referenceNumber
    ) {
        $methodName = "/Data/CreateDirectInteracTransaction";

        $data = [
                    "OriginMerchantId" => $originMerchantId,
                    "InteracInformation" => $interacInformation,
                    "DepositDueDate" => $depositDueDate,
                    "Currency" => $currency,
                    "Language" => $language,
                    "Amount" => $amount,
                    "ReferenceNumber" => $referenceNumber
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create Transaction From Raw
     * @param string $merchantId
     * @param array $rawAcpFileContent
     *
     * @return json
     */
    public function createTransactionFromRaw($merchantId, $rawAcpFileContent)
    {
        $methodName = "/Data/CreateTransactionFromRaw";

        $data = [
                    "MerchantId" => $merchantId,
                    "RawAcpFileContent" => $rawAcpFileContent,
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create Free Operation
     * @param string $merchantId
     * @param string $paymentMethodId
     * @param string $transferType
     * @param string $referenceNumber
     * @param double $amount
     * @param int $language
     * @param datetime $transactionDueDate
     * @param string $groupId
     * @param string transferFrequency
     *
     * @return json
     */
    public function createFreeOperation(
        $merchantId,
        $paymentMethodId,
        $transferType,
        $referenceNumber,
        $amount,
        $language,
        $transactionDueDate,
        $groupId,
        $transferFrequency
    ) {
        $methodName = "/Data/CreateFreeOperation";

        $data = [
                    "MerchantId" => $merchantId,
                    "PaymentMethodId" => $paymentMethodId,
                    "TransferType" => $transferType,
                    "ReferenceNumber" => $referenceNumber,
                    "Amount" => $amount,
                    "Language" => $language,
                    "TransactionDueDate" => $transactionDueDate,
                    "GroupId" => $groupId,
                    "TransferFrequency" => $transferFrequency
                ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Delete Payment
     * @param string $paymentId
     *
     * @return json
     */
    public function deletePayment($paymentId)
    {
        $methodName = "/Data/DeletePayment";

        $data = ["PaymentId" => $paymentId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Revert Transfer
     * @param string $transferId
     *
     * @return json
     */
    public function revertTransfer($transferId)
    {
        $methodName = "/Data/RevertTransfer";

        $data = ["TransferId" => $transferId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Get Recuring Transfers
     * @param string $serviceId
     *
     * @return json
     */
    public function getRecuringTransfers($serviceId)
    {
        $methodName = "/Data/GetRecuringTransfers";

        $data = ["ServiceId" => $serviceId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Delete Recuring Transfers
     * @param string $recuringTransferId
     *
     * @return json
     */
    public function deleteRecuringTransfer($recuringTransferId)
    {
        $methodName = "/Data/DeleteRecuringTransfer";

        $data = ["RecuringTransferId" => $recuringTransferId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * List Executed Operation
     * @param date $fromDate
     * @param date $toDate
     * @param string $transferType
     * @param string $transferGroupId
     * @param booles $onlyWithErrors
     * @param string $merchantId
     * @param date $dateType
     *
     * @return json
     */
    public function listExecutedOperations(
        $fromDate,
        $toDate,
        $transferType,
        $transferGroupId,
        $onlyWithErrors,
        $merchantId,
        $dateType
    ) {
        $methodName = "/Data/ListExecutedOperations";

        $data = [
            "FromDate" => $fromDate,
            "ToDate" => $toDate,
            "TransferType" => $transferType,
            "TransferGroupId" => $transferGroupId,
            "OnlyWithErrors" => $onlyWithErrors,
            "MerchantId" => $merchantId,
            "DateType" => $dateType
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /** 
     * Get DropIn Public Token
     * @param string $merchantId
     * @param double $amount
     * @param boolean $dropInAuthorizedPaymentMethod
     * @param int $language
     * @param int $transferType
     * @param string $billId
     * @param boolean $showCustomerExistingPaymentMeth
     * @param string $customerId
     * 
     * @return json
     */
    public function getDropInPublicToken(
        $merchantId,
        $amount,
        $dropInAuthorizedPaymentMethod,
        $language,
        $transferType
    ) {
        $methodName = "/Data/getDropInPublicToken";

        $data = [
            "MerchantId" => $merchantId,
            "Amount" => $amount,
            "DropInAuthorizedPaymentMethod" => $dropInAuthorizedPaymentMethod,
            "Language" => $language,
            "TransferType" => $transferType
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }
}
