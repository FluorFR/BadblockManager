<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 17/03/2018
 * Time: 18:49
 */

namespace App\Http\Controllers\moderation;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SanctionController extends Controller
{
    public function index()
    {

        $raison = [
            'Anti-Jeux / Spawnkill',
            'Aveu de cheat',
            'Cheat',
            'Cheat  + (Irrespect Staff / Perte de temps / Troll)',
            'Déconnection en vérif',
            'Diffamation',
            'Discrimination (homophobie, racisme, antisémitisme ...)',
            'Farm AFK - Anti AFK (skyblock / faction)',
            'Insulte Serveur / Communauté',
            'Insulte / Provocation / Citation de serveur',
            'Insulte Staff / Menace staff / Irrespect staff / Mensonge staff',
            'Menace (DDOS / Hack)',
            'Pillage skyblock/Duplication',
            'Plot Obscène , religieux ou non réglementé',
            'Pseudo Inapproprié / Choquant / Diffamatoir / Insultant / Obscène',
            'Publicité / Vente',
            'Question (ou insulte) en /modo inutile',
            'Recrutement staff',
            'Refus de vérif',
            'Sanction particulière',
            'Skin Injurieux ou Obscène',
            'Spam / Flood / Couleur'
        ];

        return view('section.mod.tx-sanction', ['Raison' => $raison]);
    }

    public function postSanction(){

        dd($_POST);
    }

}