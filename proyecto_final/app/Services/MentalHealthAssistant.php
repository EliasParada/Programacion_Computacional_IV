<?php

namespace App\Services;

class MentalHealthAssistant
{
    protected $positiveWords = [
        'feliz', 'contento', 'alegre', 'optimista', 'positivo', 'agradecido', 'logro', 'exito'
    ];

    protected $negativeWords = [
        'triste', 'deprimido', 'estresado', 'solitario', 'frustrado', 'desesperado', 'ansioso', 'enojado', 'acabar con mi vida', 'quiero morir'
    ];

    protected $positiveActivities = [
        "Camina al aire libre: Te ayudará a despejar la mente y reconectar con la naturaleza.",
        "Sal para correr: Liberarás endorfinas y reducirás el estrés.",
        "Prueba la natación: El agua te relajará y te sentirás aliviado.",
        "Haz yoga: Te ayudará a reducir la ansiedad y centrarte en el presente.",
        "Pasea en bicicleta: Despeja tu mente y disfruta del entorno.",
        "Baila: La música y el movimiento mejorarán tu estado de ánimo.",
        "Intenta la escalada: Te ayudará a superar pequeños retos y elevar tu ánimo.",
        "Practica boxeo o kickboxing: Libera tensiones y energía negativa.",
        "Juega en equipo: Conecta y diviértete con los demás en un juego como fútbol o baloncesto."
    ];

    protected $recreationalActivities = [
        "Pinta o dibuja: Expresa tus emociones de manera creativa.",
        "Escribe en un diario: Procesa tus emociones a través de la escritura.",
        "Lee un buen libro: Sumérgete en una historia interesante para cambiar de enfoque.",
        "Mira una película o serie: Elige algo que te inspire o te haga reír.",
        "Escucha música: Crea una playlist que te haga sentir bien.",
        "Haz jardinería: Conectar con la naturaleza es muy calmante.",
        "Arma un rompecabezas: Concéntrate y dale a tu mente un descanso.",
        "Cocina algo delicioso: Disfruta cocinando y recompénsate con algo rico.",
        "Practica meditación: Dedica unos minutos a calmar tu mente y reducir el estrés."
    ];

    public function generateResponse($noteContent, $userId)
    {
        // Limpiamos y estandarizamos el texto (quitamos espacios en blanco innecesarios y pasamos a minúsculas)
        $cleanedContent = strtolower(trim($noteContent));

        // Contamos cuántas palabras negativas y positivas están en la nota
        $positiveScore = $this->countWordsInText($cleanedContent, $this->positiveWords);
        $negativeScore = $this->countWordsInText($cleanedContent, $this->negativeWords);

        // Generamos una respuesta dependiendo de cuál puntuación es mayor
        if ($negativeScore > $positiveScore) {
            return "Parece que estás lidiando con algunos sentimientos difíciles. Recuerda que no estás solo/a, y es importante hablar de lo que sientes. Si lo deseas, puedo sugerirte algunos recursos que podrían ayudarte.";
        } elseif ($positiveScore > $negativeScore) {
            // Seleccionar una actividad positiva o recreativa al azar
            $activity = rand(0, 1) ? $this->getRandomActivity($this->positiveActivities) : $this->getRandomActivity($this->recreationalActivities);
            return "¡Es genial que estés experimentando cosas positivas! $activity";
        } else {
            return "Gracias por compartir tus pensamientos. No olvides que estoy aquí para escucharte cuando lo necesites.";
        }
    }

    // Función que cuenta las ocurrencias de palabras clave en el texto
    private function countWordsInText($text, $wordList)
    {
        $count = 0;
        foreach ($wordList as $word) {
            // Usamos str_contains para buscar las palabras clave
            if (str_contains($text, $word)) {
                $count++;
            }
        }
        return $count;
    }

    // Función que selecciona una actividad aleatoria
    private function getRandomActivity($activityList)
    {
        return $activityList[array_rand($activityList)];
    }
}
