<?php

namespace App\Exports\Sheets;

/**
 * Comentarios que el estudiante publicó en el foro, uno por fila, con la hora
 * exacta en lugar del "hace x días" que muestra la interfaz.
 */
class ForumSheet extends BaseSheet
{
    public function title(): string
    {
        return 'Forum';
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Title', 'Comment', 'Hora'];
    }

    public function array(): array
    {
        $commentsByUser = $this->context->comments()->groupBy('user_id');
        $rows = [];

        foreach ($this->context->users() as $user) {
            $comments = $commentsByUser->get($user->id, collect());

            foreach ($comments as $comment) {
                $rows[] = [
                    $user->user_id,
                    $user->name,
                    $comment->title,
                    $comment->content,
                    optional($comment->created_at)->format('d-m-Y H:i:s'),
                ];
            }
        }

        return $rows;
    }
}
