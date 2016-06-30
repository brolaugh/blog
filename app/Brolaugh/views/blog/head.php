  <meta charset="utf-8"/>
{% if blog.description %}
  <meta name="description" content="{{blog.description}}">
{% endif %}
  <meta name="keywords" content="Hello from the others side"/>
{% if author.name %}
  <meta name="author" content="{{author.name}}"/>
{% endif %}

    <link rel="stylesheet" href="http://static.brolaugh.com/blog/css/bootstrap.min.css" charset="utf-8"/>
{% if blog.stylesheet %}
  <link rel="stylesheet" href="{{ blog.stylesheet }}" charset="utf-8"/>
{% else %}
  <link rel="stylesheet" href="http://static.brolaugh.com/blog/css/material-design.min.css" charset="utf-8"/>
{% endif %}
  <title>{{blog.title}} - Brolaugh Blog Platform yo</title>
