<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = [
            ['task' => 'backend/nuevo_superadmin'],
            ['task' => 'maestros/nuevo_usuario'],
            ['task' => 'maestros/editar_usuario'],
            ['task' => 'maestros/restablecer'],
            ['task' => 'maestros/cambiar_estado_usuario'],
            ['task' => 'backend/nueva_novedad'],
            ['task' => 'backend/importar_novedades'],
            ['task' => 'backend/editar_novedad'],
            ['task' => 'backend/cambiar_estado_novedad'],
            ['task' => 'backend/novedades'],
            ['task' => 'backend/nuevo_cliente'],
            ['task' => 'backend/editar_cliente'],
            ['task' => 'backend/cambiar_estado_cliente'],
            ['task' => 'maestros/nueva_relacion'],
            ['task' => 'maestros/elimninar_relacion'],
            ['task' => 'maestros/importar_relacion'],
            ['task' => 'maestros/novedades'],
            ['task' => 'maestros/nuevo_legajo'],
            ['task' => 'maestros/importar_legajo'],
            ['task' => 'maestros/editar_legajo'],
            ['task' => 'maestros/cambiar_estado_legajo'],
            ['task' => 'maestros/legajos'],
            ['task' => 'registro-novedades/indexKpiLegajo'],
            ['task' => 'registro-novedades/nuevo'],
            ['task' => 'registro-novedades/editar'],
            ['task' => 'registro-novedades/desinformar'],
            ['task' => 'registro-novedades/eliminar'],
            ['task' => 'registro-novedades'],
            ['task' => 'registro-novedades/exportar'],
            ['task' => 'kpi'],
            ['task' => 'elegir_cliente'],
            ['task' => 'logout'],
            ['task' => 'maestros/usuarios'],
            ['task' => 'backend/clientes'],
            ['task' => 'backend/usuarios'],
            ['task' => 'editarInformacionPropia'],
            ['task' => 'registro-novedades/download']
        ];
        DB::table('tasks')->insert($tasks);
    }
}
