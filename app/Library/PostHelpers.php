<?php 

use App\Models\Post;

class PostHelpers {

	public function __construct()
	{

		$this->data = json_decode(file_get_contents(base_path().'/resources/views/core/posts/config.json'),true);
	}



	static function latestpost(  )
	{
		$sql = Post::latestposts();
		$content = '
		
		<ul class="widgeul"> ';
		foreach($sql as $row) :
		$content .='<li>
		<b><a href="'. url('post/view/'.$row->pageID.'/'.$row->alias).'"> '. $row->title .'</a></b><br />
		<span> '. date("M j, Y " , strtotime($row->created)) .' </span>
		</li>';
		endforeach ;
		$content .='</ul>';

		return $content;
	}

	public static function cloudtags()
	{
		$tags = array();	
		$keywords = array();
		$word = '';
		$data = \DB::table('tb_pages')->where('pagetype','post')->get();
		foreach($data as $row)
		{
			$clouds = explode(',',$row->labels);
			foreach($clouds as $cld)
			{
				$cld = strtolower($cld);
				if (isset($tags[$cld]) )
				{
					$tags[$cld] += 1;
				} else {
					$tags[$cld] = 1;
				}
				//$tags[$cld] = trim($cld);
			}
		}

		ksort($tags);
		foreach($tags as $tag=>$size)
		{
			//$size += 12;
			$word .= "<a href='".url('post/label/'.trim($tag))."'><span class='cloudtags' ><i class='fa fa-tag'></i> ".ucwords($tag)." (".$size.") </span></a> ";
		}

		return $word;
	}	

	static function formatContent( $content )
	{
	    // character(s) to escape
	    $x = '`~!#^*()-_+={}[]:\'"<>.';
	    $content = preg_replace_callback('#(?<!\\\)!!([^\n]+?)!!#', function($m) use($x) {
	        $s = htmlentities($m[1], ENT_NOQUOTES);
	        return  self::__fnc($s, $x);
	    }, $content);
	    $content = preg_replace_callback('#\<php\>(.+?)\<\/php\>#s',create_function(
		    '$matches',

		    '$attr["code"] = $matches[1];
		    return  view("core.code", $attr);'
		  ), $content);
	    $content = preg_replace_callback('#\<pre\>(.+?)\<\/pre\>#s',create_function(
		    '$matches',
		    'return "<pre class=\"prettyprint lang-php\">".htmlentities($matches[1])."</pre>";'
		  ), $content);	    
		
	    return $content;
	} 

    static function __fnc( $args){
       // return 'this is function  for: '.$args;

            $c = explode("|",$args);

            if(isset($c[0]) && class_exists($c[0]) )
            {
                $args = explode(':',$c[2]);
                if(count($args)>=2)
                {
                    $value = call_user_func( array($c[0],$c[1]), $args);    
                } else {
                    $value = call_user_func( array($c[0],$c[1]), str_replace(":","','",$c[2]));     
                }
                
            } else {
                    $value = 'Class Doest Not Exists';
            }

            return $value;

    } 		
}