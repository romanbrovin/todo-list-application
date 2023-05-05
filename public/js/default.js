const toast = new bootstrap.Toast(".toast");
const toastTimeout = 500;

$(function () {
  uri = $("#uri").val();
  token2 = $("#token2").val();

  $.each($("#form").serializeArray(), function (i, field) {
    $("[name=" + field.name + "]").on("input", function (ev) {
      let placeholder = $(this).attr("placeholder");
      let maxlength = $(this).attr("maxlength");
      let lenght = $(this).val().length;

      if (maxlength && lenght > 0) {
        placeholder = placeholder + " " + lenght + "/" + maxlength;
      }

      $(this).next("label").html(placeholder);
    });
  });

  $(".s_query").click(function () {
    event.preventDefault();
    q = $(this).attr("data-query");
    pathname = parseUrl(location.href).pathname;
    location.href = pathname + "?q=" + q;
  });

  $(".btn__create").click(function () {
    actionTask("create");
  });

  $(".btn__save").click(function () {
    actionTask("save");
  });

  $(".btn__login").click(function () {
    loginUser();
  });

  $(".btn__done").click(function () {
    let taskId = $(this).closest(".item").attr("id");
    taskDone(taskId);
  });

  $(".btn__edit").click(function () {
    loader();

    let itemId = $(this).closest(".item").attr("id");
    redirect('/edit?id=' + itemId);
  });

});

function redirect(url = "reload") {
  setTimeout(function () {
    url === "reload" ? location.reload() : (location.href = url);
  }, toastTimeout);
}

function showToast(text, color) {
  // Удаление всех классов по шаблону "text-bg-"
  $(".toast").removeClass(function (index, className) {
    return (className.match(/(^|\s)text-bg-\S+/g) || []).join(" ");
  });

  // Добавление необходимого класса
  $(".toast").addClass("text-bg-" + color);
  $(".toast-body").html(text);
  toast.show();
}

function actionTask(method) {
  let vars = new Object();
  vars["token2"] = token2;

  $.each($("#form").serializeArray(), function (i, field) {
    vars[field.name] = field.value;
  });

  $("input:checkbox:checked").each(function () {
    vars[$(this).attr("name")] = 1;
  });

  let button = $(".btn__" + method);
  button.prop("disabled", true);

  loader();

  $.ajax({
    type: "POST",
    url: "/" + method,
    data: vars,
    statusCode: {
      404: function () {
        errorToken();
      },
    },
  }).done(function (response) {
    $(".is-invalid").removeClass("is-invalid");
    let toastText = "";

    if (response === "ok") {
      if (method == "create") {
        toastText = "Задача создана";
      } else if (method == "save") {
        toastText = "Задача изменена";
      }

      showToast(toastText, "success");
      redirect('/');
    } else {
      let data = JSON.parse(response);

      if (data.length > 0) {
        toastText = "&nbsp;&nbsp;Необходимо ввести:</strong>";

        for (let key in data) {
          toastText +=
            "<br>&mdash;&nbsp;&nbsp;" +
            $("#" + data[key] + "~ .feedback-short").html();
          $("#" + data[key]).addClass("is-invalid");
        }

        showToast(toastText, "danger");
      }

      button.prop("disabled", false);
      loader(0);
    }
  });
}

function taskDone(taskId) {
  let vars = new Object();
  vars["token2"] = token2;
  vars["id"] = taskId;

  $("input:checkbox:checked").each(function () {
    vars[$(this).attr("name")] = 1;
  });

  loader();

  $.ajax({
    type: "POST",
    url: "/done",
    data: vars,
    statusCode: {
      404: function () {
        errorToken();
      },
    },
  }).done(function (response) {
    $(".is-invalid").removeClass("is-invalid");
    let toastText = "";

    if (response === "ok") {
      toastText = "Задача выполена";

      showToast(toastText, "success");
      redirect();
    }
  });
}

function loginUser() {
  let vars = new Object();
  vars["token2"] = token2;

  $.each($("#form").serializeArray(), function (i, field) {
    vars[field.name] = field.value;
  });

  let button = $(".btn__login");
  button.prop("disabled", true);

  loader();

  $.ajax({
    type: "POST",
    url: "/login",
    data: vars,
    statusCode: {
      404: function () {
        errorToken();
      },
    },
  }).done(function (response) {
    $(".is-invalid").removeClass("is-invalid");
    let toastText = "";

    if (response === "ok") {
      toastText = "Вы успешно авторизованы";
      showToast(toastText, "success");
      redirect("/");
    } else {
      let data = JSON.parse(response);
      if (data.length > 0) {
        if (data == "auth") {
          toastText = "Имя пользователя или пароль введены неправильно";
          $(".form-control").addClass("is-invalid");
        } else {
          toastText = "&nbsp;&nbsp;Необходимо ввести:</strong>";

          for (let key in data) {
            toastText +=
              "<br>&mdash;&nbsp;&nbsp;" +
              $("#" + data[key] + "~ .feedback-short").html();

            $("#" + data[key]).addClass("is-invalid");
          }
        }

        showToast(toastText, "danger");
      }

      button.prop("disabled", false);
      loader(0);
    }
  });
}

function loader(value) {
  if (event) {
    event.preventDefault();
  }

  if (value === 0) {
    $(".loader").fadeOut(200);
  } else {
    $(".loader").fadeIn(200);
  }
}

function parseUrl(url) {
  let parser = document.createElement("a");
  parser.href = url;
  return parser;
}

function errorToken() {
  redirect('/auth');
}

function log(value) {
  return console.log(value);
}