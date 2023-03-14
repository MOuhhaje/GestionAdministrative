<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Matching\ValidatorInterface;

/* class UriValidat extends Controller
{
    //
} */

class UriValidat implements ValidatorInterface
{
  public function matches(Route $route, Request $request)
  {
    $path = $request->path() == '/' ? '/' : '/'.$request->path();
    return preg_match(preg_replace('/$/','i', $route->getCompiled()->getRegex()), rawurldecode($path));
  }
}