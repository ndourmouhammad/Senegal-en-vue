<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Créer les rôles
        $admin = Role::create(['name' => 'admin']);
        $guide = Role::create(['name' => 'guide']);
        $tourist = Role::create(['name' => 'touriste']);

        // Créer des permissions pour admin
        $adminPermissions = [
            'lister les utilisateurs',
            'bannir un utilisateur',
            'donner une permission',
            'modifier un role',
            'lister un role',
            'supprimer un role',
            'ajouter un role',
            'ajouter une permission',
            'lister les permissions',
            'modifier une permission',
            'supprimer une permission',
            'accepter une reservation',
            'refuser une reservation',
            'ajouter un evenement',
            'modifier un evenement',
            'supprimer un evenement',
            'ajouter un article',
            'modifier un article',
            'supprimer un article',
        ];

        foreach ($adminPermissions as $permission) {
            Permission::create(['name' => $permission])->assignRole($admin);
        }

        // Créer des permissions pour guide
        $guidePermissions = [
            'ajouter un site touristique',
            'modifier un site touristique',
            'supprimer un site touristique',
            'accepter une commande',
            'refuser une commande',
            'accepter un abonnement',
            'refuser un abonnement',
            'voir mes abonnees',
        ];

        foreach ($guidePermissions as $permission) {
            Permission::create(['name' => $permission])->assignRole($guide);
        }

        // Créer des permissions pour touriste
        $touristPermissions = [
            "s'abonner a un guide",
            'passer une reservation',
            'faire une commande',
            'noter un guide',
        ];

        foreach ($touristPermissions as $permission) {
            Permission::create(['name' => $permission])->assignRole($tourist);
        }
    }
}
