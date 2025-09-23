<?php 

namespace Modules\Website\App\Services;

use App\Models\City;
use App\Models\Country;

class CountryService
{
    protected $country;
    protected $city = null;

    public function setCountry($countryId)
    {
        $this->country = Country::find($countryId) ?? Country::whereDefault(true)->first() ?? Country::first();
        if ($this->country) {
            $defaultCity = $this->country->cities()->whereDefault(true)->first();
            $firstCity = $defaultCity ? $defaultCity : $this->country->cities()->first();
            if ($firstCity) {
                $this->setCity($firstCity->id);
            } else {
                $this->city = null;
            }
        } else {
            $this->city = null;
        }
    }

    public function getCountry()
    {
        return $this->country ?? Country::find(session('country_id')) ?? Country::whereDefault(true)->first();
    }

    public function getAllCountries()
    {
        $countries = Country::orderBy("id", "asc")->get();
        return $countries;
    }

    public function getCities() {
        return $this->country ? $this->country->cities : collect();
    }

    public function setCity($cityId)
    {
        $this->city = City::find($cityId) ?? City::whereDefault(true)->first() ?? City::first();
    }

    public function getCity()
    {
        return $this->city ?? City::find(session('city_id')) ?? City::whereDefault(true)->first();
    }
}
