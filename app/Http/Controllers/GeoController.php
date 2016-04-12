<?php

namespace Jcfk\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jcfk\Models\City;
use Jcfk\Models\Region;

/**
 * @Middleware("auth")
 */
class GeoController extends Controller
{
    /**
     * @Get("/geo/regions")
     *
     * @param Request $request
     * @param Region $region
     * @return JsonResponse
     */
    public function getRegions(Request $request, Region $region)
    {
        $countryCode = $request->get('countryCode');

        return $region->getByCountry($countryCode);
    }

    /**
     * @Get("/geo/cities")
     *
     * @param Request $request
     * @param City $city
     * @return JsonResponse
     */
    public function getCities(Request $request, City $city)
    {
        $regionCode = $request->get('regionCode');

        return $city->getByRegion($regionCode);
    }
}
