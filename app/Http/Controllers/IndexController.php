<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Service;
use App\Portfolio;
use App\People;
use DB;

class IndexController extends Controller
{
    public function execute(Request $request) {

        $pages = Page::all();
        //пример
        $portfolios = Portfolio::get(array('name', 'filter', 'images'));
        $services = Service::where('id', '<', 20)->get();
        $people = People::take(3)->get();

        $tags = DB::table('portfolios')->distinct()->pluck('filter'); //pluck вместо lists


        $menu = array();
        foreach ($pages as $page) {
            $item = array('title'=>$page->name, 'alias'=>$page->alias);
            array_push($menu, $item);
        }
        $item = array('title'=>'Services', 'alias'=>'service');
        array_push($menu, $item);

        $item = array('title'=>'Portfolio', 'alias'=>'Portfolio');
        array_push($menu, $item);

        $item = array('title'=>'Team', 'alias'=>'team');
        array_push($menu, $item);

        $item = array('title'=>'Contact', 'alias'=>'contact');
        array_push($menu, $item);

        return view('site.index', array(
            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'people' => $people,
            'tags' => $tags

        ));
    }
}
