<?php

namespace App\Http\Controllers\Annotations ;

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     }),

 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"),

 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"),

 * @OA\Consumes({
 *     "multipart/form-data"
 * }),

 *

 * @OA\POST(
 *     path="/api/deconnecter",
 *     summary="Deconnexion",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Authentification"},
*),


 * @OA\GET(
 *     path="/api/utilisateurConnecte",
 *     summary="Infos de l'utilisateur connecte",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Authentification"},
*),


 * @OA\POST(
 *     path="/api/actualiserJeton",
 *     summary="actualiser mon tocken",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Authentification"},
*),


 * @OA\POST(
 *     path="/api/guides/{guide}/noter",
 *     summary="Noter un guide",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="path", name="guide", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="note", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Authentification"},
*),


 * @OA\POST(
 *     path="/api/inscrire",
 *     summary="Inscription",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="name", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                     @OA\Property(property="password_confirmation", type="string"),
 *                     @OA\Property(property="photo_profil", type="string", format="binary"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="date_naissance", type="string"),
 *                     @OA\Property(property="langues", type="string"),
 *                     @OA\Property(property="numero_carte_guide", type="string"),
 *                     @OA\Property(property="carte_guide", type="string", format="binary"),
 *                     @OA\Property(property="note", type="string"),
 *                     @OA\Property(property="role", type="string"),
 *                     @OA\Property(property="genre", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Authentification"},
*),


 * @OA\POST(
 *     path="/api/modifierInformations",
 *     summary="Mise a jour de mes infos",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="name", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                     @OA\Property(property="password_confirmation", type="string"),
 *                     @OA\Property(property="photo_profil", type="string", format="binary"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="date_naissance", type="string"),
 *                     @OA\Property(property="langues", type="string"),
 *                     @OA\Property(property="numero_carte_guide", type="string"),
 *                     @OA\Property(property="carte_guide", type="string", format="binary"),
 *                     @OA\Property(property="note", type="string"),
 *                     @OA\Property(property="genre", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Authentification"},
*),


 * @OA\POST(
 *     path="/api/connecter",
 *     summary="Connexion",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Authentification"},
*),


*/

 class AuthentificationAnnotationController {}
