jQuery(document).ready(function ($) {
  //console.log($);

  const { action, ajax_url, nonce } = twsp;

  $("#twsp_form").on("submit", function (e) {
    e.preventDefault();

    let form = $(this);
    let form_data = form.serializeArray();
    form_data.push({ name: "action", value: action });
    form_data.push({ name: "nonce", value: nonce });

    console.log(form_data);

    $.ajax({
      url: ajax_url,
      method: "POST",
      data: form_data,
      //  dataType: "json",
      cache: false,
      success: function (response) {
        // console.log("Success:", response);
        if (response.success) {
          // 🔥 WP standard
          form[0].reset();
          alert(response.message);
        } else {
          alert(response.message || "Something went wrong");
        }
        // alert(response.message);
      },
      error: function (err) {
        console.log("faileds");
        console.log("Error:", err);
      },
    });
    // dont submit the form normally
    return false;
  });
});
