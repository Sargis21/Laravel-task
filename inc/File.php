<?php

        if($request->hasFile('photo')):
            foreach ($files = $request->file('photo') as  $file)
            {
                $item->images()->create([
                    'img' => $file->store('images')
                ]);
            }
        endif;


