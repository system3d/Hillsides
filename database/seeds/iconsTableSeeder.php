<?php

use Illuminate\Database\Seeder;


use App\Icone as icon;

class iconsTableSeeder extends Seeder
{
    public function run()
    {
        $icon_model = new icon;

        $icon             = new $icon_model;
        $icon->icone       = 'agenda.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'alarm-clock.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'avatar-1.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'calculator.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'car.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'connections.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'credit-card.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'cutlery.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'documents.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'download.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'edit.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'envelope.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'error.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'eye.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'flag.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'folder.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'garbage.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'home.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'information.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'layers.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'light-bulb.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'like.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'location.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'map.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'medal.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'message.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'money.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'monitor.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'notification.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'padlock.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'photo-camera.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'presentation.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'printer.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'reload.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'search.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'settings-1.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'shield.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'shopping-cart.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'speech-bubble.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'telephone.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'tick.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'trophy.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'unlocked.png';
        $icon->timestamps = false;
        $icon->save();

        $icon             = new $icon_model;
        $icon->icone       = 'video-camera.png';
        $icon->timestamps = false;
        $icon->save();
    }
}
