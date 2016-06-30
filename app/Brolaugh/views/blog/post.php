{% extends 'base.php' %}
{% block head %}
  {% include 'blog/head.php'%}
{% endblock %}

{% block body %}
  {% include 'blog/header.php'%}
  <div class="container-fluid">
      <div class="row">
        {% include 'blog/sidemenu.php'%}
          <main class="col-md-8">
            {% include 'blog/post/post.php' %}
          </main>
          <aside class="col-md-2">
              Ads
          </aside>
      </div>


  </div>
{% endblock %}
