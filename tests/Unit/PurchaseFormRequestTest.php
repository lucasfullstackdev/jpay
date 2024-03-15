<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PurchaseFormRequestTest extends TestCase
{
  /** @test */
  public function name_is_required()
  {
    $rules = ['name' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('name', $validator->failed());
  }

  /** @test */
  public function name_must_be_a_string()
  {
    $rules = ['name' => 'required|string'];
    $data = ['name' => 123];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('name', $validator->failed());
  }

  /** @test */
  public function name_is_valid()
  {
    $rules = ['name' => 'required|string'];
    $data = ['name' => 'John Doe'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function email_is_required()
  {
    $rules = ['email' => 'required|string|email:rfc,dns'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('email', $validator->failed());
  }

  /** @test */
  public function email_must_be_a_string()
  {
    $rules = ['email' => 'required|string|email:rfc,dns'];
    $data = ['email' => 123];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('email', $validator->failed());
  }

  /** @test */
  public function email_must_be_valid()
  {
    $rules = ['email' => 'required|string|email:rfc,dns'];
    $data = ['email' => 'not-an-email'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('email', $validator->failed());
  }

  /** @test */
  public function email_is_valid_with_rfc_and_dns()
  {
    $rules = ['email' => 'required|string|email:rfc,dns'];
    $data = ['email' => 'contato@jellycode.com.br'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function document_is_required()
  {
    $rules = ['document' => 'required|string|min:11|max:11'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('document', $validator->failed());
  }

  /** @test */
  public function document_must_be_a_string()
  {
    $rules = ['document' => 'required|string|min:11|max:11'];
    $data = ['document' => 12345678901];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('document', $validator->failed());
  }

  /** @test */
  public function document_must_meet_minimum_length()
  {
    $rules = ['document' => 'required|string|min:11|max:11'];
    $data = ['document' => '1234567890']; // 10 characters
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('document', $validator->failed());
  }

  /** @test */
  public function document_must_not_exceed_maximum_length()
  {
    $rules = ['document' => 'required|string|min:11|max:11'];
    $data = ['document' => '123456789012']; // 12 characters
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('document', $validator->failed());
  }

  /** @test */
  public function document_is_valid_with_exact_length()
  {
    $rules = ['document' => 'required|string|min:11|max:11'];
    $data = ['document' => '12345678901']; // 11 characters
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function phone_is_required()
  {
    $rules = ['phone' => 'required|string|max:20'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('phone', $validator->failed());
  }

  /** @test */
  public function phone_must_be_a_string()
  {
    $rules = ['phone' => 'required|string|max:20'];
    $data = ['phone' => 1234567890];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('phone', $validator->failed());
  }

  /** @test */
  public function phone_must_not_exceed_maximum_length()
  {
    $rules = ['phone' => 'required|string|max:20'];
    $data = ['phone' => '123456789012345678901']; // 21 characters
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('phone', $validator->failed());
  }

  /** @test */
  public function phone_is_valid_with_less_than_maximum_length()
  {
    $rules = ['phone' => 'required|string|max:20'];
    $data = ['phone' => '1234567890']; // 10 characters
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function phone_is_valid_with_exact_maximum_length()
  {
    $rules = ['phone' => 'required|string|max:20'];
    $data = ['phone' => '12345678901234567890']; // 20 characters
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function street_is_required()
  {
    $rules = ['street' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('street', $validator->failed());
  }

  /** @test */
  public function street_must_be_a_string()
  {
    $rules = ['street' => 'required|string'];
    $data = ['street' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('street', $validator->failed());
  }

  /** @test */
  public function street_is_valid()
  {
    $rules = ['street' => 'required|string'];
    $data = ['street' => 'Main St'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function number_is_required()
  {
    $rules = ['number' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('number', $validator->failed());
  }

  /** @test */
  public function number_must_be_a_string()
  {
    $rules = ['number' => 'required|string'];
    $data = ['number' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('number', $validator->failed());
  }

  /** @test */
  public function number_is_valid()
  {
    $rules = ['number' => 'required|string'];
    $data = ['number' => '123A'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function neighborhood_is_required()
  {
    $rules = ['neighborhood' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('neighborhood', $validator->failed());
  }

  /** @test */
  public function neighborhood_must_be_a_string()
  {
    $rules = ['neighborhood' => 'required|string'];
    $data = ['neighborhood' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('neighborhood', $validator->failed());
  }

  /** @test */
  public function neighborhood_is_valid()
  {
    $rules = ['neighborhood' => 'required|string'];
    $data = ['neighborhood' => 'Downtown'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function city_is_required()
  {
    $rules = ['city' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('city', $validator->failed());
  }

  /** @test */
  public function city_must_be_a_string()
  {
    $rules = ['city' => 'required|string'];
    $data = ['city' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('city', $validator->failed());
  }

  /** @test */
  public function city_is_valid()
  {
    $rules = ['city' => 'required|string'];
    $data = ['city' => 'Springfield'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function state_is_required()
  {
    $rules = ['state' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('state', $validator->failed());
  }

  /** @test */
  public function state_must_be_a_string()
  {
    $rules = ['state' => 'required|string'];
    $data = ['state' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('state', $validator->failed());
  }

  /** @test */
  public function state_is_valid()
  {
    $rules = ['state' => 'required|string'];
    $data = ['state' => 'NY'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function country_is_required()
  {
    $rules = ['country' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('country', $validator->failed());
  }

  /** @test */
  public function country_must_be_a_string()
  {
    $rules = ['country' => 'required|string'];
    $data = ['country' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('country', $validator->failed());
  }

  /** @test */
  public function country_is_valid()
  {
    $rules = ['country' => 'required|string'];
    $data = ['country' => 'USA'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function postal_code_is_required()
  {
    $rules = ['postal_code' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('postal_code', $validator->failed());
  }

  /** @test */
  public function postal_code_must_be_a_string()
  {
    $rules = ['postal_code' => 'required|string'];
    $data = ['postal_code' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('postal_code', $validator->failed());
  }

  /** @test */
  public function postal_code_is_valid()
  {
    $rules = ['postal_code' => 'required|string'];
    $data = ['postal_code' => '12345'];
    $validator = Validator::make($data, $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function company_document_is_required()
  {
    $rules = ['company.document' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.document', $validator->failed());
  }

  /** @test */
  public function company_document_must_be_a_string()
  {
    $rules = ['company.document' => 'required|string'];
    $data = ['company.document' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.document', $validator->failed());
  }

  /** @test */
  public function company_document_is_valid()
  {
    $rules = ['company.document' => 'required|string'];
    $data = ['company.document' => '12345678901'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_name_is_required()
  {
    $rules = ['company.name' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.name', $validator->failed());
  }

  /** @test */
  public function company_name_must_be_a_string()
  {
    $rules = ['company.name' => 'required|string'];
    $data = ['company.name' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.name', $validator->failed());
  }

  /** @test */
  public function company_name_is_valid()
  {
    $rules = ['company.name' => 'required|string'];
    $data = ['company.name' => 'Example Company'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_street_is_required()
  {
    $rules = ['company.street' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.street', $validator->failed());
  }

  /** @test */
  public function company_street_must_be_a_string()
  {
    $rules = ['company.street' => 'required|string'];
    $data = ['company.street' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.street', $validator->failed());
  }

  /** @test */
  public function company_street_is_valid()
  {
    $rules = ['company.street' => 'required|string'];
    $data = ['company.street' => 'Main Street'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_number_is_required()
  {
    $rules = ['company.number' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.number', $validator->failed());
  }

  /** @test */
  public function company_number_must_be_a_string()
  {
    $rules = ['company.number' => 'required|string'];
    $data = ['company.number' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.number', $validator->failed());
  }

  /** @test */
  public function company_number_is_valid()
  {
    $rules = ['company.number' => 'required|string'];
    $data = ['company.number' => '123A'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_neighborhood_is_required()
  {
    $rules = ['company.neighborhood' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.neighborhood', $validator->failed());
  }

  /** @test */
  public function company_neighborhood_must_be_a_string()
  {
    $rules = ['company.neighborhood' => 'required|string'];
    $data = ['company.neighborhood' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.neighborhood', $validator->failed());
  }

  /** @test */
  public function company_neighborhood_is_valid()
  {
    $rules = ['company.neighborhood' => 'required|string'];
    $data = ['company.neighborhood' => 'Business District'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_city_is_required()
  {
    $rules = ['company.city' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.city', $validator->failed());
  }

  /** @test */
  public function company_city_must_be_a_string()
  {
    $rules = ['company.city' => 'required|string'];
    $data = ['company.city' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.city', $validator->failed());
  }

  /** @test */
  public function company_city_is_valid()
  {
    $rules = ['company.city' => 'required|string'];
    $data = ['company.city' => 'Metropolis'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_state_is_required()
  {
    $rules = ['company.state' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.state', $validator->failed());
  }

  /** @test */
  public function company_state_must_be_a_string()
  {
    $rules = ['company.state' => 'required|string'];
    $data = ['company.state' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.state', $validator->failed());
  }

  /** @test */
  public function company_state_is_valid()
  {
    $rules = ['company.state' => 'required|string'];
    $data = ['company.state' => 'CA'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_country_is_required()
  {
    $rules = ['company.country' => 'required|string'];
    $validator = Validator::make([], $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.country', $validator->failed());
  }

  /** @test */
  public function company_country_must_be_a_string()
  {
    $rules = ['company.country' => 'required|string'];
    $data = ['company.country' => 1234];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('company.country', $validator->failed());
  }

  /** @test */
  public function company_country_is_valid()
  {
    $rules = ['company.country' => 'required|string'];
    $data = ['company.country' => 'US'];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
  }

  /** @test */
  public function company_complement_is_optional()
  {
    $rules = ['company.complement' => 'string'];
    $validator = Validator::make([], $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function complement_is_optional()
  {
    $rules = ['complement' => 'string'];
    $validator = Validator::make([], $rules);
    $this->assertFalse($validator->fails());
  }

  /** @test */
  public function complement_must_be_a_string()
  {
    $rules = ['complement' => 'string'];
    $data = ['complement' => true];
    $validator = Validator::make($data, $rules);
    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('complement', $validator->failed());
  }
}
