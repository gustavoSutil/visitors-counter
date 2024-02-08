 <?php

namespace  App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
  
class ProfileController extends Controller
{
  protected string $GITHUB_API_URL = 'https://api.github.com/users/';

  protected string $username;
  protected string $background_color = '#000000';
  protected string $text_color = '#ffffff';
  protected int $size; 
  protected int $initial;
  protected string $text = '';
  protected bool $bold = false;

  public function index(Request $request,string $username){
    try{
      $response = Http::get($this->GITHUB_API_URL . $username);
      $status = $response->status();
      if ($status > 299) {
          return 'Usuario não encontrado! Verifique seu username no github.' . $status;   
      }
      $this->username = $username;
      $this->background_color = '#'.$request->query('background_color','000000');
      $this->text_color = '#'.$request->query('text_color','ffffff');
      $this->size = $request->query('size',11);
      $this->initial = $request->query('initial', 0);
      $text_request = $request->query('text','');
      $this->text = Str::replace('_', ' ', $text_request);
      $this->bold = $request->query('bold', false);
      
      $profile = $this->findUser();
      $quantity = $profile->acesses + 1;

      DB::table('profiles')
      ->where('username', $this->username)
      ->update(['acesses' => $quantity]);

      $background_color = $this->background_color;
      $text_color = $this->text_color;
      $size = $this->size;
      $text = $this->text;
      $bold = $this->bold;
      $style_bold = $bold ? ' font-weight="bold" ' : '';
      
      
      $aux = $quantity;
      if ($aux > 10) {
        for ($decimal_point = 1 ; 10 < $aux; $decimal_point++ ){
          $aux /= 10;
        }
      }else{
        $decimal_point = 1;
      }
      $decimal_point += strlen($text);

      return Response(
    (
    '<svg xmlns="http://www.w3.org/2000/svg" width="' . ($size * 1.18181818182 * $decimal_point)/2 . '" height="' . ($size * 1.18181818182 + 2) . '" role="img" aria-label="visitors count">' .
  '<title>visitors count</title>'.
      '<g shape-rendering="crispEdges">' .
        '<rect x="0" width="' . ($size * 1.18181818182 * $decimal_point)/2 . '" height="' . ($size * 1.18181818182 + 2)/2 . '" fill="' . $background_color . '" />' .
      '</g>' .
      '<g '.$style_bold.' fill="' . $text_color  . '" text-anchor="middle" text-rendering="geometricPrecision"'.
      ' font-family="\'Segoe UI\', Ubuntu, \'Helvetica Neue\', Sans-Serif"'. 
   ' font-size="' . $size . '">' .
        '<text'.$style_bold.' x="' . ($size * 1.18181818182 * $decimal_point)/4 . '" y="' . ($size * 1.18181818182) . '" font-family="\'Segoe UI\', Ubuntu, \'Helvetica Neue\', Sans-Serif" fill="' . $text_color . '">'. $text .$quantity.'</text>'.
      '</g>' .
    '</svg>'
    )
    )->header('Content-Type', 'image/svg+xml');

    }catch (Exeption $e){
      return $e->getMensage();
    }
  }

  protected function findUser(){
    $profile = Profile::where('username', $this->username)->first();
    if(!$profile){
      return  Profile::create([
        'username' => $this->username,
        'acesses' => $this->initial]);
      }
    else{
      return $profile;
    }
  }
}
