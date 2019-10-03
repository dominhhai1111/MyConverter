<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

class ConverterController extends Controller
{
    public function index() {
        return view('converter.index');
    }

    public function converter(Request $request) {
        if ($request->hasFile('converter.file')) {
            $file = $request->file('converter.file');
            $params = $request->get('converter');
            $params['file'] = $file;
            $converterFilePath = $this->handleConverterToMp3($params);
            
            try {
                return $this->downloadFile($converterFilePath);
            } catch (\Exception $ex) {
                throw($ex);
            }
        }

        return redirect(route('index'));
    }

    public function handleConverterToMp3($params) {
        list('file' => $file, 'gender' => $gender, 'speed' => $speed, 'effect' => $effect) = $params;
        $filename = $file->getClientOriginalName();
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        $converterFilePath = public_path() . '/' . $filename . ".mp3";
        $content = '';

        if (!empty($file)) {
            $delimeter1 = '<break strength="medium"/>';
            $delimeter2 = '<break strength="weak"/>';
            $content = file_get_contents($file->getRealPath());

            $contents = $this->splitFile($content);
            $audioContents = '';

            foreach ($contents as $content) {
                $content = str_replace('.', $delimeter1, $content);
                $content = str_replace(',', $delimeter2, $content);
                $content = "<speak>$content</speak>";
    
                putenv('GOOGLE_APPLICATION_CREDENTIALS=../My First Project-bf16db5860ef.json');
    
                // instantiates a client
                $client = new TextToSpeechClient();
    
                // sets text to be synthesised
                $synthesisInputText = (new SynthesisInput())
                    // ->setText($content);
                    ->setSsml($content);
    
                // build the voice request, select the language code ("en-US") and the ssml
                // voice gender
                $voice = (new VoiceSelectionParams())
                    ->setLanguageCode('vi')
                    // ->setSsmlGender(SsmlVoiceGender::MALE);
                    ->setSsmlGender($gender);
    
                // Effects profile
                $effectsProfileId = $effect;
    
                // select the type of audio file you want returned
                $audioConfig = (new AudioConfig())
                    ->setAudioEncoding(AudioEncoding::MP3)
                    ->setEffectsProfileId(array($effectsProfileId))
                    ->setSpeakingRate($speed);
    
                // perform text-to-speech request on the text input with selected voice
                // parameters and audio file type
                $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
                $audioContent = $response->getAudioContent();

                $audioContents .= $audioContent;
            }
            

            // the response's audioContent is binary
            file_put_contents("$filename.mp3", $audioContents);
        }
        
        return $converterFilePath;
    }

    public function downloadFile($filePath) {
        return response()->download($filePath);
    }

    private function splitFile($content) {
        $content = trim(preg_replace('/\s+/', ' ', $content));
        $sentences = explode('.', $content);
        $contents = [];
        $tmpContent = '';

        foreach ($sentences as $key => $sentence) {
            $sentence = trim($sentence);
            if (strlen($tmpContent) + strlen($sentence) < 5000) {
                if (strlen($tmpContent)) {
                    $tmpContent .= ". $sentence";
                } else {
                    $tmpContent .= $sentence;
                }

                if ($key == sizeof($sentences) - 1) {
                    $contents[] = $tmpContent;
                }
            } else {
                $contents[] = $tmpContent;
                $tmpContent = '';
                $tmpContent .= $sentence;
            }
        }

        return $contents;
    }
}
