<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class FeedbackTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('feedback_types')->insert([
            [            
                'id' => 1,
                'name' => 'Short Message A',
                'level' => 'exercise',
                'text_based' => true,
                'description' => 'Un mensaje breve para los ejercicios que no tienen respuestas correctas o incorrectas. Aparece al final luego de que el estudiante le de click a “submit”.'
            ],
            [            
                'id' => 2,
                'name' => 'Short Message B',
                'level' => 'exercise',
                'text_based' => true,
                'description' => 'únicamente para respuestas correctas. Mensajes como: Well done!, Excellent!, Very good!, Good job! Aparece al final cuando todo el ejercicio esté correcto luego de dar click a “Check”.',
            ],
            [            
                'id' => 3,
                'name' => 'Elaborative',
                'level' => 'question',
                'text_based' => false,
                'description' => 'Aparece un extracto de audio en donde se encuentra la respuesta correcta. Este feedback es a nivel de preguntas dentro de un ejercicio y está disponible para preguntas correctas e incorrectas. Se habilita luego de que el estudiante de click a “check”.',
            ],
            [            
                'id' => 4,
                'name' => 'Short Message C',
                'level' => 'exercise',
                'text_based' => true,
                'description' => 'únicamente para cuando un ejercicio tiene respuestas incorrectas. Mensajes como “Try again”, Don’t give up”, “oops” mas un mensaje personalizado de lo que podría hacer el estudiante para hallar la respuesta correcta dependiendo del ejercicio. Aparece al final cuando el estudiante le de click a “check”.',
            ],
            [            
                'id' => 5,
                'name' => 'Explanatory',
                'level' => 'question',
                'text_based' => true,
                'description' => 'Mensaje de texto donde se explique la razón por la que está incorrecta la respuesta. Este feedback es a nivel de preguntas dentro de un ejercicio y se habilita luego de que el estudiante de click a “check”.',
            ],
            [            
                'id' => 6,
                'name' => 'Directive',
                'level' => 'question',
                'text_based' => true,
                'description' => 'Mensaje de texto donde se sugiera qué estrategias u opciones de ayuda podría usar el estudiante. Este feedback es a nivel de preguntas dentro de un ejercicio y se habilita luego de que el estudiante de click a “check”.',
            ],
            [            
                'id' => 7,
                'name' => 'Knowledge of correct response',
                'level' => 'question',
                'text_based' => true,
                'description' => 'Mensaje de texto en donde se dice cuál es la respuesta correcta y por qué. Este feedback es a nivel de preguntas dentro de un ejercicio y se habilita luego de que el estudiante de click a “check”.',
            ],
        ]);
    }
}
