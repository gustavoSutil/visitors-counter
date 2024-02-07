<svg xmlns="http://www.w3.org/2000/svg" width="max-content" height="max-content" role="img" aria-label="visitors count">
  <title>visitors count</title>
  <g shape-rendering="crispEdges">
    <rect x="0" width="{{$size * 1.18181818182 * $decimal_point}}" height="{{$size * 1.18181818182 + 2}}" fill="{{$backgrond_color}}" />
  </g>
  <g fill="#fff" text-anchor="middle" text-rendering="geometricPrecision" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" 
    font-size="{{$size}}">
    <text x="{{($size * 1.18181818182 * $decimal_point)/2}}" y="{{$size * 1.18181818182}}" fill="#fff" font-family="Segoe UI', Ubuntu, 'Helvetica Neue', Sans-Serif" fill="{{$backgrond_color}}">    
      {{$quantity}}
    </text>
  </g>
</svg>

<style>
  html,body{
    padding: 0px;
    margin: 0px;
  }
</style>