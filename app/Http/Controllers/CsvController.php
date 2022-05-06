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
            "Tags",
            "Published",

            "Option1 Name",
            "Option1 Value",
            "Option2 Name",
            "Option2 Value",
            "Option3 Name",
            "Option3 Value",

            "Variant SKU",
            "Variant Grams",
            'Variant Weight Unit',
            'Variant Inventory Tracker',
            'Variant Inventory Qty',
            'Variant Inventory Policy',
            'Variant Fulfillment Service',
            'Variant Price',
            'Variant Compare At Price',
            'Variant Requires Shipping',
            'Variant Taxable',

            "Image Src",
            "Image Position",
            "Image Alt Text",

            "Status"
        ]);

        $numberOfProduct = 1;

        $StandardizedProductType = [ "Arts & Entertainment", "Baby & Toddler", "Cameras & Optics", "Apparel & Accessories", "Electronics", "Luggage & Bags", "Office Supplies", "Religious & Ceremonial", "Mature"];

        $option1 = "Color";
        $option1vals = ["Large", "Small", "Medium"];

        $option2 = "Size";
        $option2vals = ["Red", "Green", "Black", "White"];

        $option3 = "Material";
        $option3vals = ["Plastic", "Rubber", "Metal"];

        //adding the data from the array
        for($i=0; $i<$numberOfProduct; $i++) {

            $title = $faker->realText(50);
            $_handle = Str::slug($title);
            $desc = $faker->text(200);
            $vendor = $faker->word;
            
            

            $type = $StandardizedProductType[$rand_keys = array_rand($StandardizedProductType,1)];

            $published = true;
            
            
            $nOfoption1 = mt_rand(1,3);
            shuffle( $option1vals );
            for($j=0;$j<$nOfoption1;$j++){
                
                $nOfoption2 = mt_rand(1,4);
                shuffle( $option2vals );

                for($k=0;$k<$nOfoption2;$k++){
                    
                    
                    $nOfoption3 = mt_rand(1,3);
                    shuffle( $option3vals );

                    for($m=0;$m<$nOfoption3;$m++){
                        dump($option1vals[$j] . "-" .$option2vals[$k]. "-" .$option3vals[$m]);
                        
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
                            // $option1val,
                            $option2,
                            // $option2val,
                            $option3,
                            // $option3val,
                            $qty,
                            $fullfilment_service,
                            $vprice,
                            $vprice,
                            $src,
                            1,
                            "active"
                        ]);

                    }
                }
            }
            dd($nOfoption1,$nOfoption2,$nOfoption3);
            

            


            
        }
        // fclose($handle);

        //download command
        // return Response::download($filename, "download.csv", $headers);
        echo "Done";
    }
}
