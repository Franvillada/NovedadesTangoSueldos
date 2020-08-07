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
            ['task' => 'superadmin'],
            ['task' => 'registrarUsuario'],
            ['task' => 'editarUsuario'],
            ['task' => 'restablecerPassword'],
            ['task' => 'cambiarEstadoUsuario'],
            ['task' => 'nuevaNovedad'],
            ['task' => 'importarNovedad'],
            ['task' => 'editarNovedad'],
            ['task' => 'cambiarEstadoNovedad'],
            ['task' => 'indexNovedades'],
            ['task' => 'nuevoCliente'],
            ['task' => 'editarCliente'],
            ['task' => 'cambiarEstadoCliente'],
            ['task' => 'nuevaRelacion'],
            ['task' => 'elimninarRelacion'],
            ['task' => 'importarRelacion'],
            ['task' => 'indexRelacion'],
            ['task' => 'nuevoLegajo'],
            ['task' => 'importarLegajo'],
            ['task' => 'editarLegajo'],
            ['task' => 'cambiarEstadoLegajo'],
            ['task' => 'indexLegajos'],
            ['task' => 'indexKpiLegajo'],
            ['task' => 'nuevoRegistro'],
            ['task' => 'editarRegistro'],
            ['task' => 'cambiarEstadoRegistro'],
            ['task' => 'eliminarRegistro'],
            ['task' => 'indexRegistro'],
            ['task' => 'exportarRegistro'],
            ['task' => 'indexKpiCliente'],
            ['task' => 'elegirCliente']
        ];
        DB::table('tasks')->insert($tasks);
    }
}
