<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use App\Models\Boarding;
use Illuminate\Database\Seeder;

class BoardingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>10,
            "longitude"=>22,
            "type_id"=>2,
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>3,
            "shared_bathroom"=>1,
            "price"=>23000,
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>33,
            "longitude"=>11,
            "type_id"=>4,
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>3,
            "shared_bathroom"=>0,
            "price"=>230000,
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        Boarding::create([
            "boarding_name" =>Str::random(10).' Boarding House',
            "address"=>Str::random(10).' Boarding House',
            "latitude"=>rand(2,50),
            "longitude"=>rand(2,50),
            "type_id"=>rand(1,7),
            "boarding_desc"=>Str::random(10).'\n'.Str::random(30).'\n'.Str::random(10),
            "rooms"=>rand(1,10),
            "shared_bathroom"=>rand(0,1),
            "price"=>rand(200000,3000000),
        ]);
        
    }
}
