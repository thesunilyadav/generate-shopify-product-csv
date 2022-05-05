<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Response;
use File;
use Illuminate\Support\Str;

class CsvController extends Controller
{
    public function index()
    {   

        $faker = Factory::create();
        // return $faker->realText(40);
        // $input = array("Neo","Morpheus","Trinity","Cypher","Tank");
        
        // // $rand_keys = array_rand($input,1);
        // // return $rand_keys;
        // $users = User::get();

        // these are the headers for the csv file.
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename =  public_path("files/download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            "Handle",
            "Title",
            "Body (HTML)",
            "Vendor",
            "Standardized Product Type",
            "Published",
            "Option1 Name",
            "Option1 Value",
            "Option2 Name",
            "Option2 Value",
            "Option3 Name",
            "Option3 Value",

            'Variant Inventory Qty',
            
            'Variant Fulfillment Service',

            'Variant Price',
            'Variant Compare At Price',

            "Image Src",
            "Image Position",
            "Status"
        ]);

        //adding the data from the array
        for($i=0; $i<10; $i++) {

            $title = $faker->realText(50);
            $_handle = Str::slug($title);
            $desc = $faker->text(200);
            $vendor = $faker->word;
            
            $StandardizedProductType = [ "Arts & Entertainment", "Baby & Toddler", "Cameras & Optics", "Apparel & Accessories", "Electronics", "Luggage & Bags", "Office Supplies", "Religious & Ceremonial", "Mature"];

            $type = $StandardizedProductType[$rand_keys = array_rand($StandardizedProductType,1)];

            $published = true;
            
            $option1 = "Color";
            $optin1vals = ["Large", "Small", "Medium", "Extra Small", "Extra Large"];
            $option1val = $optin1vals[array_rand($optin1vals,1)];
            
            $option2 = "Size";
            $optin2vals = ["Red", "Green", "Blue", "Pink", "Yellow"];
            $option2val = $optin2vals[array_rand($optin2vals,1)];
            
            $option3 = "Material";
            $optin3vals = ["Plastic", "Rubber", "ceramic", "metal", "composites"];
            $option3val = $optin3vals[array_rand($optin3vals,1)];

            $qty = $faker->numberBetween(10,50);            
            $fullfilment_service = 'manual';
            $vprice = $faker->numberBetween($min = 100, $max = 600);
            $src = "https://picsum.photos/300/300";


            fputcsv($handle, [
                $_handle,
                $title,
                $desc,
                $vendor,
                $type,
                $published,
                $option1,
                $option1val,
                $option2,
                $option2val,
                $option3,
                $option3val,
                $qty,
                $fullfilment_service,
                $vprice,
                $vprice,
                $src,
                1,
                "active"
            ]);

        }
        fclose($handle);

        //download command
        return Response::download($filename, "download.csv", $headers);
    }
}
