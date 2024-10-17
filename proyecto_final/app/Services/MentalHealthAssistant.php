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
            return "¡Es genial que estés experimentando cosas positivas! Seguir compartiendo tus pensamientos y sentimientos puede ayudarte a mantener esa actitud positiva.";
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
}
