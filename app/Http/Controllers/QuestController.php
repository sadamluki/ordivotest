<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Abstracts\Motorboat;
use App\Http\Abstracts\SailBoat;
use App\Http\Abstracts\Yacht;

class QuestController extends Controller
{
    function pattern_count(Request $request)
    {
        $text = $request->text;
        $pattern = $request->pattern;
        $count = 0;

        if (
            strlen($text) > 0 &&
            strlen($pattern) > 0 &&
            strlen($text) > strlen($pattern)
        ) {
            $split_text = str_split($text);
            // dd($split_text);
            for ($i = 0; $i < strlen($text); $i++) {
                $string_maker = '';
                for ($j = 0; $j < strlen($pattern); $j++) {
                    isset($split_text[$i + $j])
                        ? ($string_maker .= $split_text[$i + $j])
                        : '';
                }
                // dd($string_maker);
                $string_maker == $pattern ? $count++ : '';
            }
        }

        return $count;
    }

    function array_depth(array $array)
    {
        $max_depth = 1;

        // dd($array[0]);

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }

    public function count_child($array, $string, $depth)
    {
        $counter = 0;
        for ($i = 0; $i < count($array); $i++) {
            if (
                is_string($array[$i]) &&
                !empty($array[$i]) &&
                str_contains($array[$i], $string)
            ) {
                $counter += $depth;
            }

            if (is_array($array[$i])) {
                $counter += $this->count_child($array[$i], $string, $depth + 1);
            }
        }

        return $counter;
    }

    public function sum_deep(Request $request)
    {
        $string_array = str_split($request->chars);
        $array = json_decode($request->array);
        $depth = 0;
        $sum_all = 0;
        // dd($array);

        if (!empty($array) && !empty($string_array)) {
            for ($j = 0; $j < count($string_array); $j++) {
                $counting = 0;
                $string = $string_array[$j];
                $counting += $this->count_child($array, $string, $depth + 1);
                $sum_all += $counting * ($j + 1);
            }
        }

        return $sum_all;
    }

    function get_scheme(Request $request)
    {
        $html = $request->html;
        // $html = '<i sc-root="Hello">World</i>';
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);
        $output = $this->get_scheme_node($xpath->query('//body')->item(0));
        return json_encode($output[0]);
    }

    function get_scheme_node($node)
    {
        $scheme = [];
        $children = [];
        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attribute) {
                if (strpos($attribute->name, 'sc-') === 0) {
                    $scheme[substr($attribute->name, 3)] = $attribute->value;
                }
            }
        }
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $child) {
                if ($child->nodeType == XML_ELEMENT_NODE) {
                    $children[] = $this->get_scheme_node($child);
                }
            }
        }
        if (!empty($scheme)) {
            array_unshift($children, $scheme);
        }
        return $children;
    }

    public function polymorphism()
    {
        $motorBoat = new MotorBoat('Motor Boat 1', 2020, 60, 10, 200);
        $sailBoat = new SailBoat('Sail Boat 1', 2019, 40, 8, 100);
        $yacht = new Yacht('Yacht 1', 2018, 50, 6, 4);
        // dd($motorBoat->getEnginePower());

        $ships = [];
        array_push($ships, $motorBoat);
        array_push($ships, $sailBoat);
        array_push($ships, $yacht);

        print_r($ships);

        // foreach ($ships as $ship) {
        //     echo $ship->getName();
        //     echo $ship->getType();
        // }

        // return json_encode($ships);
    }
}
