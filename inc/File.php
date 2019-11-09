<?php
use App\Image;

        if($request->hasFile('photo')):
            foreach ($files = $request->file('photo') as  $file)
            {
                $paths[] = $file->store('images');
            }
            foreach ($paths as $path):
                Image::create([
                'product_id'=> isset($product) ? $product->id : $item->id,
                'img'=>$path
            ]);
            endforeach;
        endif;



