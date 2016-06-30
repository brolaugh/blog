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
            <div id="posts">
                {% for post in posts %}
                    {% include 'blog/post/post.php'%}
                {% else %}
                    <p>
                      I'm sorry to say that there is no posts.
                    </p>
                {% endfor %}
            </div>
            {% include 'base/pagination.php' %}
        </main>
        <aside class="col-md-2">
            Ads
        </aside>
    </div>


</div>
{% endblock %}
