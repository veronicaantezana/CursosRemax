<?php

namespace App\Http\Controllers\Curso;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CourseController extends Controller
{
       public function index(Request $request)
    {
        $category = $request->query('category');
        $allCourses = [
           [
                'id' => 1,
                'titulo' => 'Derecho Inmobiliario',
                'instructor' => 'Dr. Juan Pérez',
                'descripcion' => 'Aprenderás la diferencia entre posesión, propiedad...',
                'imagen' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400',
                'duracion' => '5 horas',
                'totalTemas' => 11,
                'categoria' => 'legales-regulatorios',
                'rating' => 4.8,
                'nivel' => 'Intermedio'
            ],
            [
                'id' => 2,
                'titulo' => 'Marketing Inmobiliario',
                'instructor' => 'Ana Rodríguez',
                'descripcion' => 'Estrategias avanzadas de marketing...',
                'imagen' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=400',
                'duracion' => '8 horas',
                'totalTemas' => 8,
                'categoria' => 'marketing-comunicacion',
                'rating' => 4.6,
                'nivel' => 'Avanzado'
            ],
            [
                'id' => 3,
                'titulo' => 'Tasación y Avalúos',
                'instructor' => 'Carlos Méndez',
                'descripcion' => 'Domina las técnicas profesionales de tasación...',
                'imagen' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                'duracion' => '6 horas',
                'totalTemas' => 6,
                'categoria' => 'bienes-y-raices',
                'rating' => 4.7,
                'nivel' => 'Intermedio'
            ],
            [
                'id' => 4,
                'titulo' => 'Contratos Inmobiliarios',
                'instructor' => 'María González',
                'descripcion' => 'Aprende a redactar y entender los principales contratos...',
                'imagen' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400',
                'duracion' => '4 horas',
                'totalTemas' => 5,
                'categoria' => 'legales-regulatorios',
                'rating' => 4.5,
                'nivel' => 'Principiante'
            ]
        ];
         $cursos = $category 
            ? array_filter($allCourses, fn($curso) => $curso['categoria'] === $category)
            : $allCourses;

        return Inertia::render('Cursos/Index', [
            'cursos' => array_values($cursos),
            'category' => $category
        ]);
    }

     public function show($id)
    {
        // Buscar el curso específico por ID
        $curso = [
            'id' => (int) $id,
            'titulo' => 'Derecho Inmobiliario',
            'descripcion' => 'Aprenderás la diferencia entre posesión, propiedad y otros derechos reales. Conocerás las leyes, reglamentos y jurisprudencia que rigen el sector inmobiliario.',
            'imagen' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400',
            'rating' => 4.8,
            'reseñas' => 1247,
            'duracion' => '5 horas',
            'nivel' => 'Intermedio',
            'totalTemas' => 11,
            'instructor' => 'Dr. Juan Pérez',
            'categoria' => 'legales-regulatorios'
        ];

       
        $temas = [
            [
            'id' => 1,
                'titulo' => 'Fundamentos y Actores del Sector Inmobiliario',
                'duracion' => '1h 3min',
                'descripcion' => 'Introducción a los conceptos básicos del derecho inmobiliario. Aprenderás sobre los diferentes actores que participan en el sector y sus roles específicos.',
                'recursos' => [
                    ['id' => 1, 'nombre' => 'PDF - Fundamentos', 'url' => '#', 'tipo' => 'PDF'],
                    ['id' => 2, 'nombre' => 'Presentación', 'url' => '#', 'tipo' => 'PowerPoint']
                ]
            ],
            [
                'id' => 2,
                'titulo' => 'Marco Legal y Regulatorio',
                'duracion' => '31min',
                'descripcion' => 'Conocerás las leyes, reglamentos y jurisprudencia',
                 'recursos' => [
                    ['id' => 1, 'nombre' => 'PDF - Fundamentos', 'url' => '#', 'tipo' => 'PDF'],
                    ['id' => 2, 'nombre' => 'Presentación', 'url' => '#', 'tipo' => 'PowerPoint']
                ]
            ],
            [
                'id' => 3,
                'titulo' => 'Marco Legal y Regulatorio 3',
                'duracion' => '31min',
                'descripcion' => 'Conocerás las leyes, reglamentos y jurisprudencia',
                 'recursos' => [
                    ['id' => 1, 'nombre' => 'PDF - Fundamentos', 'url' => '#', 'tipo' => 'PDF'],
                    ['id' => 2, 'nombre' => 'Presentación', 'url' => '#', 'tipo' => 'PowerPoint']
                ]
            ],
            [
                'id' => 4,
                'titulo' => 'Marco Legal y Regulatorio 4',
                'duracion' => '31min',
                'descripcion' => 'Conocerás las leyes, reglamentos y jurisprudencia',
                 'recursos' => [
                    ['id' => 1, 'nombre' => 'PDF - Fundamentos', 'url' => '#', 'tipo' => 'PDF'],
                    ['id' => 2, 'nombre' => 'Presentación', 'url' => '#', 'tipo' => 'PowerPoint']
                ]
            ],
        ];

        return Inertia::render('Cursos/Show', [
            'curso' => $curso,
            'temas' => $temas  
        ]);
    }
     public function buscar(Request $request)
    {
        
        return Inertia::render('Cursos/Buscar', [
            'results' => [],
            'query' => $request->query('q')
        ]);
    }
}
