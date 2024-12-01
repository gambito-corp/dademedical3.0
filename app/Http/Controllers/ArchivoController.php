<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Services\Archivo\ArchivoService;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    public function __construct(private ArchivoService $archivoService) {}

    public function getUrl($rutaArchivo)
    {
        // Decodificar la ruta si viene codificada
        $rutaArchivo = urldecode($rutaArchivo);

        // Obtener la URL pre-firmada
        $url = $this->archivoService->obtenerUrlImagen($rutaArchivo);

        if ($url) {
            // Redirigir directamente a la URL pre-firmada
            return redirect($url);
        } else {
            abort(404, 'El archivo no existe');
        }
    }


    public function getFile($id)
    {
        $hash = new Hashids();
        $id = $hash->decode($id)[0];

        if (Auth::user()){
            $file = Archivo::query()->where('id', $id)->first();
            $archivo = Storage::disk('archivos')->get($file->ruta);
            $code = 200;
            $type = Storage::disk('archivos')->mimeType($file->ruta);
            return new Response($archivo, $code, ['Content-Type' => $type]);
        }else{
            return response()->json(['message' => 'No autorizado'], 401);
        }
    }
}
