<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Regole di validazione per creare e modificare un post (store e update)
class PostRequest extends FormRequest
{
    // L'autorizzazione è già gestita altrove:
    // il middleware 'auth' controlla il login, PostPolicy controlla l'autore
    public function authorize(): bool
    {
        return true;
    }

    // Regole valide sia per la creazione che per la modifica
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
}
