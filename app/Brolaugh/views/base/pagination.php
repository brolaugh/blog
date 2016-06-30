<ul class="pagination">
  {% if utility.currentPage > 1 %}
    <li><a href="/{{ blog.name }}/page/1">««</a></li>
    <li><a href="/{{ blog.name }}/page/{{ utility.currentPage - 1 }}">«</a></li>
  {% else %}
      <li class="disabled"><a href="javascript:void(0)">««</a></li>
      <li class="disabled"><a href="javascript:void(0)">«</a></li>
  {% endif %}

  {% for page in utility.pagination %}
      {% if page == utility.currentPage %}
        <li class="active">
          <a href="javascript:void(0)">
          {{ utility.currentPage }}
        </a>
        </li>
      {% else %}
        <li>
          <a href="/{{ blog.name }}/page/{{ page }}">
            {{ page }}
          </a>
        </li>

      {% endif %}
  {% endfor %}
{% if utility.currentPage < utility.totalPages %}
  <li>
    <a href="/{{ blog.name }}/page/{{ utility.currentPage + 1 }}">»</a>
  </li>
  <li>
    <a href="/{{ blog.name }}/page/{{ utility.totalPages }}">»»</a>
  </li>
{% else %}
  <li class="disabled">
    <a href="javascript:void(0)">»</a>
  </li>

    <li class="disabled">
      <a href="javascript:void(0)">»»</a>
    </li>
{% endif %}
</ul>
