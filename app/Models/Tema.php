<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'nombre',
        'duracion',
        'archivo_path',
        'url',
        'tipo_archivo'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function materiales()
    {
        return $this->hasMany(Material::class);
    }

    public function detectarTipoArchivo($archivo = null, $url = null)
    {
        if ($archivo) {
            $extension = strtolower($archivo->getClientOriginalExtension());
            $tipos = [
                'pdf' => ['pdf'],
                'word' => ['doc', 'docx'],
                'powerpoint' => ['ppt', 'pptx'],
                'excel' => ['xls', 'xlsx'],
                'imagen' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                'video' => ['mp4', 'avi', 'mov', 'wmv']
            ];

            foreach ($tipos as $tipo => $extensiones) {
                if (in_array($extension, $extensiones)) {
                    return $tipo;
                }
            }
        }

        if ($url) {
            return 'video'; // Asumimos que las URLs son videos
        }

        return 'archivo';
    }

    // Accesores para icono y color
    public function getIconoAttribute()
    {
        $iconos = [
            'pdf' => 'pi pi-file-pdf',
            'word' => 'pi pi-file-word',
            'powerpoint' => 'pi pi-file-powerpoint',
            'excel' => 'pi pi-file-excel',
            'video' => 'pi pi-video',
            'imagen' => 'pi pi-image',
            'archivo' => 'pi pi-file'
        ];

        return $iconos[$this->tipo_archivo] ?? 'pi pi-file';
    }

    public function getColorAttribute()
    {
        $colores = [
            'pdf' => 'text-red-600',
            'word' => 'text-blue-600',
            'powerpoint' => 'text-orange-600',
            'excel' => 'text-green-600',
            'video' => 'text-red-500',
            'imagen' => 'text-purple-600',
            'archivo' => 'text-gray-600'
        ];

        return $colores[$this->tipo_archivo] ?? 'text-gray-600';
    }

    public function getNombreArchivoAttribute()
    {
        if ($this->archivo_path) {
            return basename($this->archivo_path);
        }
        return null;
    }

    public function tieneArchivo()
    {
        return !is_null($this->archivo_path);
    }

    public function tieneUrl()
    {
        return !is_null($this->url) && $this->url !== '';
    }
}
