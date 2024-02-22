<?php

namespace App\Enums;

enum SignerAs: string
{
  case ACCOUNT_HOLDER = 'account_holder';
  case ACCOUNTANT = 'accountant';
  case ADMINISTRATOR = 'administrator';
  case APPROVE = 'approve';
  case ASSOCIATE = 'associate';
  case ATTORNEY = 'attorney';
  case BAILEE = 'bailee';
  case BROKER = 'broker';
  case BUYER = 'buyer';
  case CO_RESPONSIBLE = 'co_responsible';
  case COLLATERAL_PROVIDER = 'collateral_provider';
  case COMFORTER = 'comforter';
  case CONSENTING = 'consenting';
  case CONSIGNEE = 'consignee';
  case CONTRACTEE = 'contractee';
  case CONTRACTOR = 'contractor';
  case CREDITOR = 'creditor';
  case DEBTOR = 'debtor';
  case DISTRACTED = 'distracted';
  case DISTRACTING = 'distracting';
  case EMPLOYEE = 'employee';
  case EMPLOYER = 'employer';
  case ENDOSEE =  'endorsee';
  case ENDORSER = 'endorser';
  case FRANCHISEE = 'franchisee';
  case FRANCHISOR = 'franchisor';
  case GRANTEE = 'grantee';
  case GRANTOR = 'grantor';
  case GUARANTOR = 'guarantor';
  case INSURED = 'insured';
  case INTERVENING = 'intervening';
  case ISSUER = 'issuer';
  case JOINT_DEBTOR = 'joint_debtor';
  case LAWYER = 'lawyer';
  case LEGAL_REPRESENTATIVE = 'legal_representative';
  case LENDER = 'lender';
  case LESSEE = 'lessee';
  case LESSOR = 'lessor';
  case MANAGER = 'manager';
  case PARTNER = 'partner';
  case PARTY = 'party';
  case PLEDGED = 'pledged';
  case PRESIDENT = 'president';
  case RATIFY = 'ratify';
  case RECEIPT = 'receipt';
  case SELLER = 'seller';
  case SIGN = 'sign';
  case SIGNED = 'signed';
  case SURETY = 'surety';
  case TRANSFEREE = 'transferee';
  case TRANSFEROR = 'transferor';
  case VALIDATOR = 'validator';
  case WITNESS = 'witness';
}
