<?php

namespace App\Http\Requests;

use App\Rules\Cni;
use App\Rules\CodeSecret;
use App\Rules\Telephone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompte extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "client" => ['required', 'array'],
            "client.nom" => ['required', 'string', 'min:2', 'max:255'],
            "client.prenom" => ['required', 'string', 'min:2', 'max:255'],
            "client.adresse" => ['required', 'string', 'min:5', 'max:500'],
            "client.telephone" => ['required', 'string', new \App\Rules\Telephone],
            "client.cni" => ['required', 'string', new \App\Rules\Cni],
            // "client.code_secret" => ['required', 'string', new \App\Rules\CodeSecret],
            "type" => ['required', 'string', Rule::in(['client', 'distributeur'])],
        ];
    }
    public function messages()
    {
        return [
            "client.required" => 'Les informations du client sont obligatoires.',
            "client.array" => 'Les informations du client doivent être un objet JSON valide.',
            "client.nom.required" => 'Le nom du client est obligatoire.',
            "client.nom.string" => 'Le nom doit être une chaîne de caractères.',
            "client.nom.min" => 'Le nom doit contenir au moins 2 caractères.',
            "client.nom.max" => 'Le nom ne peut pas dépasser 255 caractères.',
            "client.prenom.required" => 'Le prénom du client est obligatoire.',
            "client.prenom.string" => 'Le prénom doit être une chaîne de caractères.',
            "client.prenom.min" => 'Le prénom doit contenir au moins 2 caractères.',
            "client.prenom.max" => 'Le prénom ne peut pas dépasser 255 caractères.',
            "client.adresse.required" => 'L\'adresse du client est obligatoire.',
            "client.adresse.string" => 'L\'adresse doit être une chaîne de caractères.',
            "client.adresse.min" => 'L\'adresse doit contenir au moins 5 caractères.',
            "client.adresse.max" => 'L\'adresse ne peut pas dépasser 500 caractères.',
            "client.telephone.required" => 'Le numéro de téléphone est obligatoire.',
            "client.telephone.unique" => 'Ce numéro de téléphone existe déjà.',
            "client.cni.required" => 'Le numéro CNI est obligatoire.',
            // "client.code_secret.required" => 'Le code secret est obligatoire.',
            "type.required" => 'Le type de compte est obligatoire.',
            "type.string" => 'Le type de compte doit être une chaîne de caractères.',
            "type.in" => 'Le type de compte doit être soit "client" soit "distributeur".',
        ];
    }
}
