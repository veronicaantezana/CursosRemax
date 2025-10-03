<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'tema_id',
        'archivo_path',
        'url',
        'tipo'
    ];

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function detectarTipo($archivo = null, $url = null)
    {
        if ($archivo) {
            $extension = strtolower($archivo->getClientOriginalExtension());
            $tipos = [
                'pdf' => ['pdf'],
                'word' => ['doc', 'docx'],
                'powerpoint' => ['ppt', 'pptx'],
                'excel' => ['xls', 'xlsx'],
                'imagen' => ['jpg', 'jpeg', 'png', 'gif', 'webp']
            ];
            
            foreach ($tipos as $tipo => $extensiones) {
                if (in_array($extension, $extensiones)) {
                    return $tipo;
                }
            }
        }

        if ($url) {
            return 'video'; 
        }

        return 'archivo'; 
    }

    public function getNombreAttribute()
    {
        if ($this->archivo_path) {
            return basename($this->archivo_path);
        }
        if ($this->url) {
            return 'Video externo';
        }
        return 'Material';
    }

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

        return $iconos[$this->tipo] ?? 'pi pi-file';
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

        return $colores[$this->tipo] ?? 'text-gray-600';
    }
}