<?php

namespace App\Http\Controllers\controller;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // Listado de estudiantes
    public function index()
    {
        // Obtenemos la lista de estudiantes
        $students = Student::all();

        // Si la lista de estudiantes esta vacia
        if($students->isEmpty()) {
            $data = [
                'message' => 'No se encontraron estudiantes',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        // Retornamos la lista
        $data = [
            'students' => $students,
            'status'   => 200
        ];

        return response()->json($data, 200);
    }

    // Estudiante por id
    public function show($id)
    {
        // Buscamos al estudiante por su id
        $student = Student::find($id);

        // Si no se encontro al estudiante
        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        // Si se encontro al estudiante
        // Retornamos sus datos
        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    // Registrar nuevo estudiante
    public function store(Request $request)
    {
        // Validamos los campos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:9',
            'language' => 'required|in:English,Spanish'
        ]);

        // Si la validacion falla
        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        // Registamos al estudiante con los datos recibidos
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ]);

        // Si no se pudo registrar al estudiante
        if(!$student) {
            $data = [
                'message' => 'Error al crear el estudiante',
                'status'  => 500
            ];
            return response()->json($data, 500);
        }

        // Si todo salio bien retornamos los datos del estudiante creado
        $data = [
            'student' => $student,
            'status'  => 201
        ];

        return response()->json($data, 201);
    }

    // Actualizar estudiante por id
    public function update(Request $request, $id)
    {
        // Buscamos al estudiante por su id
        $student = Student::find($id);

        // Si no se encontro al estudiante
        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        // Validamos los campos
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:9',
            'language' => 'required|in:English,Spanish'
        ]);

        // Si la validacion falla
        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status'  => 200
        ];

        return response()->json($data, 200);
    }

    // Actualizar estudiante de forma parcial por id
    public function updatePartial(Request $request, $id)
    {
        // Buscamos al estudiante por su id
        $student = Student::find($id);

        // Si no se encontro al estudiante
        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        // Validamos los campos
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:9',
            'language' => 'in:English,Spanish'
        ]);

        // Si la validacion falla
        if($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if($request->has('name')) {
            $student->name = $request->name;
        }

        if($request->has('email')) {
            $student->email = $request->email;
        }

        if($request->has('phone')) {
            $student->phone = $request->phone;
        }

        if($request->has('language')) {
            $student->language = $request->language;
        }

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status'  => 200
        ];

        return response()->json($data, 200);
    }

    // Eliminar estudiante por id
    public function destroy($id)
    {
        // Buscamos al estudiante por su id
        $student = Student::find($id);

        // Si no se encontro al estudiante
        if(!$student){
            $data = [
                'message' => 'Estudiante no encontrado',
                'status'  => 404
            ];
            return response()->json($data, 404);
        }

        // Si se encontró al estudiante
        // Lo eliminamos y retornamos una respuesta
        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);

    }

}
