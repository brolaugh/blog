<!DOCTYPE html>
<html>
    <head>
        {% block head%} {% endblock %}
    </head>
    <body>
        {% block body %} {% endblock %}
        {% block footer %}
          {% include 'footer.php'%}
        {% endblock %}
    </body>
</html>
