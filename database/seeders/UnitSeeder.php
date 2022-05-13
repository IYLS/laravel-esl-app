<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            [            'title' => 'Talk 1 - Soft Electronics',
            'author' => 'Roozbeh Ghaffari',
            'description' => 'Roozbeh Ghaffari,MC10 cofounder, talks about soft electronics and its use in fields such as medicine.',
            'listening_tips' => "Pay attention to the pauses and how the speaker stresses some words to draw the listener's attention to key words and concepts.",
            'cultural_notes' => '',
            'technology_notes' => '1. Arrhythmia: an arrhythmia is a problem with the rate or rhythm of the heartbeat. During an arrhythmia, the heart can beat too fast, too slow, or with an irregular rhythm.

            2. Atrial fibrillation: is the most common cardiac arrhythmia (heart rhythm disorder.)
            
            3. Balloon Catheter: type of "soft" catheter with an inflatable "balloon" at its tip which is used during a catheterization procedure to enlarge a narrow opening or passage within the body. 
            
            4. Biomedical devices: wide variety of implements that are beneficial for human health and welfare. 
            
            5. Microfabrication: is the process of fabrication of miniature structures of micrometer scales and smaller.
            
            6. Orders of magnitude: an order of magnitude is a scale of numbers with a fixed ratio, often rounded to the nearest ten.
            
            7. Rigid electronics: electronics that are not flexible. 
            
            8- Soft tissue: in anatomy, the term soft tissue refers to tissues that connect, support, or surround other structures and organs of the body, not being bone. ',
            'biology_notes' => '',
            'transcript' => "Electronics are hard, rigid, and brutal. But what if electronics were soft, flexible, and curvy like the human body, imagine electronics that could bend, stretch, and fit on your body like a Band-Aid, or a child's tattoo. Imagine the implications. 


            Today's our electronics are stiffer by up-to six orders of magnitude, compared to soft tissue in the human body. Now, six orders of magnitude, to appreciate this difference, consider an example of comparable magnitude difference in terms of a small insect compared to the tallest peaks of one of my favorite mountains,K2.5 kilometers in size, that's what 6 orders of magnitude difference looks like. 
            
            
            We can now bridge this sort of gap that exist between rigid electronics and soft biological systems, by exploiting a few simple and elegant microfabrication techniques and tricks, much like a rigid piece of wood that can be thinned and oriented-down to a soft, flexible sheet of tissue paper, we can take a rigid block of silicone as in a wafer form, thin it down into flexible silicone ribbons and then re-orient and re-purpose them to make stretchable electronics, giving micro-spring-like structures in between them. And what we achieve are tissue-like electronics that can be laminated on the skin, as in a band-aid, which are invisible to the user, and mechanically isolated.
            
            
            We can also achieve tissue-like sensors that can be laminated on internal organs like the heart, to gain insight into problems like atrial fibrillation. And finally we can build systems that are minimally invasive like a balloon catheter that can be deflated and inflated inside the heart, to track arrhythmias and as well as delivering therapy and diagnosis all in one single device, giving the stretchable electronics. 
            
            
            Finally, soft-by integrated electronics have implications over  a broad range of different applications including consumer and biomedical devices, these devices that we've shown here have the potential to fundamentally change the way and bridge the gap between electronics and biology and these the way these systems interchange and interact.",
            'glossary' => "1- Band-Aid (noun): trade name for an adhesive bandage to cover small cuts or wounds. Example: As a school nurse, Pat was used to carry Band-Aids with her to heal lots of scraped knees and elbows.

            2- Curvy (adjective): having curves. Example: The road is in good condition, but the area is mountainous and curvy.
            
            3- Invasive (adjective): tending to spread very quickly and undesirably or harmfully. Example: Cancer that has spread throughout your body is an example of invasive cancer.
            
            4- Rigid (adjective):  unable to bend or be forced out of shape; not flexible. Example: This bottle is made of rigid plastic; I cannot bend it. 
            
            5- Silicone ribbons (noun): a ribbon made of silicone. Example: Susan bought a flexible silicone ribbon that controls the shape and size of her abdominal area.
            
            6- Stiffer (adjective): difficult to bend; rigid. Example: He had stiff leather shoes on.
            
            7- Tissue paper (noun): thin, soft paper, typically used for wrapping or protecting fragile or delicate articles. Example: Tissue paper used in grabbing pretzels and other food items will also be environmentally friendly.
            
            8- To be laminated on (verb): to split into thin layers or sheets. Example: We laminated on cheese to protect it against moisture loss. 
            
            9- To Bend (verb): to cause to assume a curved or angular shape. Example: A blacksmith is bending a piece of iron into a horseshoe.  
            
            10- To bridge the gap (expression): to make a connection where there is a great difference. Example: The senator tried to bridge the gap between the two versions of the bill. 
            
            11- To gain sight (idiom): the ability to see. Example: The sailor gained sight of the land after 40 days at sea.
            
            12- To Stretch (verb): to make (something) wider or longer by pulling it. Example: The little girl stretched the sweater out of shape.
            
            13- To thin down (idiom): to become thinner or slimmer. Example: The hospital dietician tried to thin down the obese man.",
            'translation' => 'Los aparatos electrónicos son duros, rígidos y brutales. Pero żqué pasaría si los electrónicos fueran suaves, flexibles y curvilíneos como el cuerpo humano? Imaginen electrónicos que pudiesen doblarse, estirarse y adaptarse al cuerpo como una tira adhesiva sanitaria, o un tatuaje de nińo. Imaginen las implicaciones. 

            Hoy, nuestros electrónicos son más rígidos hasta 6 órdenes de magnitud, comparados con el tejido blando del cuerpo humano. Ahora, 6 órdenes de magnitud, para apreciar la diferencia, consideren un ejemplo de una diferencia de magnitud comparable en términos de un insecto pequeńo comparado con el pico más alto de una de mis montańas favoritas. Clave: 2:5 kilómetros en porte, eso es como una diferencia de 6 órdenes de magnitud se ve. 
            
            Ahora podemos conectar este tipo de espacio que existe entre los electrónicos rígidos y los sistemas biológicos suaves a través de la explotación de simples y elegantes técnicas y trucos de microfabricación, algo parecido a un trozo de madera rígida que puede ser adelgazada y orientada a una suave y flexible hoja de un pańuelo de papel, o podemos tomar un bloque rígido de silicona como en forma de una oblea, adelgazarla en unas pulseras de silicona y después orientarlas hacia el objetivo de hacerlas unos electrónicos flexibles, dándoles estructuras como de "micro-spring"ť entre ellas. Y lo que obtendremos serán electrónicos como de papel suave que pueden ser laminados en la piel, como tiras adhesivas sanitarias, que son invisibles para el usuario y aislados mecánicamente. 
            
            También podremos obtener sensores como de papel suave que pueden ser laminados en órganos internos como el corazón, para comprender mejor algunos problemas como la fibrilación auricular. Y finalmente podemos construir sistemas que son mí­nimamente invasivos como un catéter de balón que puede ser desinflado e inflado dentro del corazón, para llevarle la pista a arritmias, así como también terapia y diagnóstico todo en un dispositivo, dado la flexibilidad de los electrónicos.
            
            Finalmente, electrónicos suaves integrados tienen implicaciones más allá de un rango de diferentes implicaciones incluyendo dispositivos del consumidor y biomédicos. Estos dispositivos que hemos mostrado aquí­ tienen la potencialidad de cambiar fundamentalmente la manera en que podemos unir el espacio entre los electrónicos y la biología y la manera en que estos sistemas se intercambian e interactúan.',
            'dictionary' => '',
            'video_url' => 'http://www.esl-iyls.com/videos/n1/n1t1.mp4',
            'proficiency_level_id' => 2,
            'group_id' => 2,
        ],
            [            'title' => 'Talk 2 - Soft Electronics',
            'author' => 'Roozbeh Ghaffari',
            'description' => 'Roozbeh Ghaffari,MC10 cofounder, talks about soft electronics and its use in fields such as medicine.',
            'listening_tips' => "Pay attention to the pauses and how the speaker stresses some words to draw the listener's attention to key words and concepts.",
            'cultural_notes' => '',
            'technology_notes' => '1. Arrhythmia: an arrhythmia is a problem with the rate or rhythm of the heartbeat. During an arrhythmia, the heart can beat too fast, too slow, or with an irregular rhythm.

            2. Atrial fibrillation: is the most common cardiac arrhythmia (heart rhythm disorder.)
            
            3. Balloon Catheter: type of "soft" catheter with an inflatable "balloon" at its tip which is used during a catheterization procedure to enlarge a narrow opening or passage within the body. 
            
            4. Biomedical devices: wide variety of implements that are beneficial for human health and welfare. 
            
            5. Microfabrication: is the process of fabrication of miniature structures of micrometer scales and smaller.
            
            6. Orders of magnitude: an order of magnitude is a scale of numbers with a fixed ratio, often rounded to the nearest ten.
            
            7. Rigid electronics: electronics that are not flexible. 
            
            8- Soft tissue: in anatomy, the term soft tissue refers to tissues that connect, support, or surround other structures and organs of the body, not being bone. ',
            'biology_notes' => '',
            'transcript' => "Electronics are hard, rigid, and brutal. But what if electronics were soft, flexible, and curvy like the human body, imagine electronics that could bend, stretch, and fit on your body like a Band-Aid, or a child's tattoo. Imagine the implications. 


            Today's our electronics are stiffer by up-to six orders of magnitude, compared to soft tissue in the human body. Now, six orders of magnitude, to appreciate this difference, consider an example of comparable magnitude difference in terms of a small insect compared to the tallest peaks of one of my favorite mountains,K2.5 kilometers in size, that's what 6 orders of magnitude difference looks like. 
            
            
            We can now bridge this sort of gap that exist between rigid electronics and soft biological systems, by exploiting a few simple and elegant microfabrication techniques and tricks, much like a rigid piece of wood that can be thinned and oriented-down to a soft, flexible sheet of tissue paper, we can take a rigid block of silicone as in a wafer form, thin it down into flexible silicone ribbons and then re-orient and re-purpose them to make stretchable electronics, giving micro-spring-like structures in between them. And what we achieve are tissue-like electronics that can be laminated on the skin, as in a band-aid, which are invisible to the user, and mechanically isolated.
            
            
            We can also achieve tissue-like sensors that can be laminated on internal organs like the heart, to gain insight into problems like atrial fibrillation. And finally we can build systems that are minimally invasive like a balloon catheter that can be deflated and inflated inside the heart, to track arrhythmias and as well as delivering therapy and diagnosis all in one single device, giving the stretchable electronics. 
            
            
            Finally, soft-by integrated electronics have implications over  a broad range of different applications including consumer and biomedical devices, these devices that we've shown here have the potential to fundamentally change the way and bridge the gap between electronics and biology and these the way these systems interchange and interact.",
            'glossary' => "1- Band-Aid (noun): trade name for an adhesive bandage to cover small cuts or wounds. Example: As a school nurse, Pat was used to carry Band-Aids with her to heal lots of scraped knees and elbows.

            2- Curvy (adjective): having curves. Example: The road is in good condition, but the area is mountainous and curvy.
            
            3- Invasive (adjective): tending to spread very quickly and undesirably or harmfully. Example: Cancer that has spread throughout your body is an example of invasive cancer.
            
            4- Rigid (adjective):  unable to bend or be forced out of shape; not flexible. Example: This bottle is made of rigid plastic; I cannot bend it. 
            
            5- Silicone ribbons (noun): a ribbon made of silicone. Example: Susan bought a flexible silicone ribbon that controls the shape and size of her abdominal area.
            
            6- Stiffer (adjective): difficult to bend; rigid. Example: He had stiff leather shoes on.
            
            7- Tissue paper (noun): thin, soft paper, typically used for wrapping or protecting fragile or delicate articles. Example: Tissue paper used in grabbing pretzels and other food items will also be environmentally friendly.
            
            8- To be laminated on (verb): to split into thin layers or sheets. Example: We laminated on cheese to protect it against moisture loss. 
            
            9- To Bend (verb): to cause to assume a curved or angular shape. Example: A blacksmith is bending a piece of iron into a horseshoe.  
            
            10- To bridge the gap (expression): to make a connection where there is a great difference. Example: The senator tried to bridge the gap between the two versions of the bill. 
            
            11- To gain sight (idiom): the ability to see. Example: The sailor gained sight of the land after 40 days at sea.
            
            12- To Stretch (verb): to make (something) wider or longer by pulling it. Example: The little girl stretched the sweater out of shape.
            
            13- To thin down (idiom): to become thinner or slimmer. Example: The hospital dietician tried to thin down the obese man.",
            'translation' => 'Los aparatos electrónicos son duros, rígidos y brutales. Pero żqué pasaría si los electrónicos fueran suaves, flexibles y curvilíneos como el cuerpo humano? Imaginen electrónicos que pudiesen doblarse, estirarse y adaptarse al cuerpo como una tira adhesiva sanitaria, o un tatuaje de nińo. Imaginen las implicaciones. 

            Hoy, nuestros electrónicos son más rígidos hasta 6 órdenes de magnitud, comparados con el tejido blando del cuerpo humano. Ahora, 6 órdenes de magnitud, para apreciar la diferencia, consideren un ejemplo de una diferencia de magnitud comparable en términos de un insecto pequeńo comparado con el pico más alto de una de mis montańas favoritas. Clave: 2:5 kilómetros en porte, eso es como una diferencia de 6 órdenes de magnitud se ve. 
            
            Ahora podemos conectar este tipo de espacio que existe entre los electrónicos rígidos y los sistemas biológicos suaves a través de la explotación de simples y elegantes técnicas y trucos de microfabricación, algo parecido a un trozo de madera rígida que puede ser adelgazada y orientada a una suave y flexible hoja de un pańuelo de papel, o podemos tomar un bloque rígido de silicona como en forma de una oblea, adelgazarla en unas pulseras de silicona y después orientarlas hacia el objetivo de hacerlas unos electrónicos flexibles, dándoles estructuras como de "micro-spring"ť entre ellas. Y lo que obtendremos serán electrónicos como de papel suave que pueden ser laminados en la piel, como tiras adhesivas sanitarias, que son invisibles para el usuario y aislados mecánicamente. 
            
            También podremos obtener sensores como de papel suave que pueden ser laminados en órganos internos como el corazón, para comprender mejor algunos problemas como la fibrilación auricular. Y finalmente podemos construir sistemas que son mí­nimamente invasivos como un catéter de balón que puede ser desinflado e inflado dentro del corazón, para llevarle la pista a arritmias, así como también terapia y diagnóstico todo en un dispositivo, dado la flexibilidad de los electrónicos.
            
            Finalmente, electrónicos suaves integrados tienen implicaciones más allá de un rango de diferentes implicaciones incluyendo dispositivos del consumidor y biomédicos. Estos dispositivos que hemos mostrado aquí­ tienen la potencialidad de cambiar fundamentalmente la manera en que podemos unir el espacio entre los electrónicos y la biología y la manera en que estos sistemas se intercambian e interactúan.',
            'dictionary' => '',
            'video_url' => 'http://www.esl-iyls.com/videos/n1/n1t1.mp4',
            'proficiency_level_id' => 1,
            'group_id' => 1,
        ],
            [            'title' => 'Talk 3 - Soft Electronics',
            'author' => 'Roozbeh Ghaffari',
            'description' => 'Roozbeh Ghaffari,MC10 cofounder, talks about soft electronics and its use in fields such as medicine.',
            'listening_tips' => "Pay attention to the pauses and how the speaker stresses some words to draw the listener's attention to key words and concepts.",
            'cultural_notes' => '',
            'technology_notes' => '1. Arrhythmia: an arrhythmia is a problem with the rate or rhythm of the heartbeat. During an arrhythmia, the heart can beat too fast, too slow, or with an irregular rhythm.

            2. Atrial fibrillation: is the most common cardiac arrhythmia (heart rhythm disorder.)
            
            3. Balloon Catheter: type of "soft" catheter with an inflatable "balloon" at its tip which is used during a catheterization procedure to enlarge a narrow opening or passage within the body. 
            
            4. Biomedical devices: wide variety of implements that are beneficial for human health and welfare. 
            
            5. Microfabrication: is the process of fabrication of miniature structures of micrometer scales and smaller.
            
            6. Orders of magnitude: an order of magnitude is a scale of numbers with a fixed ratio, often rounded to the nearest ten.
            
            7. Rigid electronics: electronics that are not flexible. 
            
            8- Soft tissue: in anatomy, the term soft tissue refers to tissues that connect, support, or surround other structures and organs of the body, not being bone. ',
            'biology_notes' => '',
            'transcript' => "Electronics are hard, rigid, and brutal. But what if electronics were soft, flexible, and curvy like the human body, imagine electronics that could bend, stretch, and fit on your body like a Band-Aid, or a child's tattoo. Imagine the implications. 


            Today's our electronics are stiffer by up-to six orders of magnitude, compared to soft tissue in the human body. Now, six orders of magnitude, to appreciate this difference, consider an example of comparable magnitude difference in terms of a small insect compared to the tallest peaks of one of my favorite mountains,K2.5 kilometers in size, that's what 6 orders of magnitude difference looks like. 
            
            
            We can now bridge this sort of gap that exist between rigid electronics and soft biological systems, by exploiting a few simple and elegant microfabrication techniques and tricks, much like a rigid piece of wood that can be thinned and oriented-down to a soft, flexible sheet of tissue paper, we can take a rigid block of silicone as in a wafer form, thin it down into flexible silicone ribbons and then re-orient and re-purpose them to make stretchable electronics, giving micro-spring-like structures in between them. And what we achieve are tissue-like electronics that can be laminated on the skin, as in a band-aid, which are invisible to the user, and mechanically isolated.
            
            
            We can also achieve tissue-like sensors that can be laminated on internal organs like the heart, to gain insight into problems like atrial fibrillation. And finally we can build systems that are minimally invasive like a balloon catheter that can be deflated and inflated inside the heart, to track arrhythmias and as well as delivering therapy and diagnosis all in one single device, giving the stretchable electronics. 
            
            
            Finally, soft-by integrated electronics have implications over  a broad range of different applications including consumer and biomedical devices, these devices that we've shown here have the potential to fundamentally change the way and bridge the gap between electronics and biology and these the way these systems interchange and interact.",
            'glossary' => "1- Band-Aid (noun): trade name for an adhesive bandage to cover small cuts or wounds. Example: As a school nurse, Pat was used to carry Band-Aids with her to heal lots of scraped knees and elbows.

            2- Curvy (adjective): having curves. Example: The road is in good condition, but the area is mountainous and curvy.
            
            3- Invasive (adjective): tending to spread very quickly and undesirably or harmfully. Example: Cancer that has spread throughout your body is an example of invasive cancer.
            
            4- Rigid (adjective):  unable to bend or be forced out of shape; not flexible. Example: This bottle is made of rigid plastic; I cannot bend it. 
            
            5- Silicone ribbons (noun): a ribbon made of silicone. Example: Susan bought a flexible silicone ribbon that controls the shape and size of her abdominal area.
            
            6- Stiffer (adjective): difficult to bend; rigid. Example: He had stiff leather shoes on.
            
            7- Tissue paper (noun): thin, soft paper, typically used for wrapping or protecting fragile or delicate articles. Example: Tissue paper used in grabbing pretzels and other food items will also be environmentally friendly.
            
            8- To be laminated on (verb): to split into thin layers or sheets. Example: We laminated on cheese to protect it against moisture loss. 
            
            9- To Bend (verb): to cause to assume a curved or angular shape. Example: A blacksmith is bending a piece of iron into a horseshoe.  
            
            10- To bridge the gap (expression): to make a connection where there is a great difference. Example: The senator tried to bridge the gap between the two versions of the bill. 
            
            11- To gain sight (idiom): the ability to see. Example: The sailor gained sight of the land after 40 days at sea.
            
            12- To Stretch (verb): to make (something) wider or longer by pulling it. Example: The little girl stretched the sweater out of shape.
            
            13- To thin down (idiom): to become thinner or slimmer. Example: The hospital dietician tried to thin down the obese man.",
            'translation' => 'Los aparatos electrónicos son duros, rígidos y brutales. Pero żqué pasaría si los electrónicos fueran suaves, flexibles y curvilíneos como el cuerpo humano? Imaginen electrónicos que pudiesen doblarse, estirarse y adaptarse al cuerpo como una tira adhesiva sanitaria, o un tatuaje de nińo. Imaginen las implicaciones. 

            Hoy, nuestros electrónicos son más rígidos hasta 6 órdenes de magnitud, comparados con el tejido blando del cuerpo humano. Ahora, 6 órdenes de magnitud, para apreciar la diferencia, consideren un ejemplo de una diferencia de magnitud comparable en términos de un insecto pequeńo comparado con el pico más alto de una de mis montańas favoritas. Clave: 2:5 kilómetros en porte, eso es como una diferencia de 6 órdenes de magnitud se ve. 
            
            Ahora podemos conectar este tipo de espacio que existe entre los electrónicos rígidos y los sistemas biológicos suaves a través de la explotación de simples y elegantes técnicas y trucos de microfabricación, algo parecido a un trozo de madera rígida que puede ser adelgazada y orientada a una suave y flexible hoja de un pańuelo de papel, o podemos tomar un bloque rígido de silicona como en forma de una oblea, adelgazarla en unas pulseras de silicona y después orientarlas hacia el objetivo de hacerlas unos electrónicos flexibles, dándoles estructuras como de "micro-spring"ť entre ellas. Y lo que obtendremos serán electrónicos como de papel suave que pueden ser laminados en la piel, como tiras adhesivas sanitarias, que son invisibles para el usuario y aislados mecánicamente. 
            
            También podremos obtener sensores como de papel suave que pueden ser laminados en órganos internos como el corazón, para comprender mejor algunos problemas como la fibrilación auricular. Y finalmente podemos construir sistemas que son mí­nimamente invasivos como un catéter de balón que puede ser desinflado e inflado dentro del corazón, para llevarle la pista a arritmias, así como también terapia y diagnóstico todo en un dispositivo, dado la flexibilidad de los electrónicos.
            
            Finalmente, electrónicos suaves integrados tienen implicaciones más allá de un rango de diferentes implicaciones incluyendo dispositivos del consumidor y biomédicos. Estos dispositivos que hemos mostrado aquí­ tienen la potencialidad de cambiar fundamentalmente la manera en que podemos unir el espacio entre los electrónicos y la biología y la manera en que estos sistemas se intercambian e interactúan.',
            'dictionary' => '',
            'video_url' => 'http://www.esl-iyls.com/videos/n1/n1t1.mp4',
            'proficiency_level_id' => 1,
            'group_id' => 1,
            ]
        ]);
    }
}
