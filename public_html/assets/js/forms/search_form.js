$(document).on("click", ".rowdelete", function (e) {
    e.preventDefault();
    let button = $(this);
    let table_name = $(this).data("table");
    let id = $(this).data("id");
    alert({
        message: _t("record_remove_accept"),
        title: _t("warning"),
        callback: function () {
            $.ajax({
                url: `${root}/admin/ajax/delete`,
                method: "post",
                data: { table: table_name, id: id },
                success: function () {
                    button.parents("tr").fadeOut(1000);
                }
            })
        }
    })
}).on("click", ".entityrowdelete", function (e) {
    e.preventDefault();
    let button = $(this);
    alert({
        message: _t("record_remove_accept_entity", [
            button.data("entity-name")
        ]),
        okLabel: _t("yes"),
        callback: function () {
            $.ajax({
                url: root + "/ajax/entityDelete",
                method: "post",
                data: { key: button.data("key") },
                success: function () {
                    button.parents("tr").fadeOut(1000);
                }
            })
        }
    });
}).on("click", "input[type='reset']", function (e) {
    e.preventDefault();
    $(this).parents("form").find("input:not([type='submit']):not([type='reset']),textarea").val("");
    loadSelect2($(this).parents("form").find("select").val("NULL"));
    $(this).parents("form").find("input[type='checkbox']").prop("checked", false).trigger("change");
});

$(function () {
    var ajaxActive = false;
    var loadMoreIntersectionObserver = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting === true) {
            if (!ajaxActive) {
                ajaxActive = true;
                let target = $(entries[0].target);
                let nextPage = target.data("page");
                target.removeClass("load-more-section invisible");
                fetch(root + "/search/getNextPage" + (location.search ? location.search + "&" : "?") + new URLSearchParams({
                    page: nextPage
                }), {
                    method: "post",
                    body: JSON.stringify({
                        token: target.data("token")
                    })
                }
                )
                    .then((response) => response.json())
                    .then((response) => {
                        if (response.data.status) {
                            let resultItems = $(response.data.render).find(".result-viewer");
                            let form = target.closest("form");
                            form.find(".result-viewer:last").after(resultItems);
                            target.addClass("load-more-section invisible")
                                .data("page", nextPage + 1);
                            ajaxActive = false;
                            form.trigger("autoload-page", [resultItems, nextPage]);
                        } else {
                            target.remove();
                        }
                    })
            }
        }
    }, { threshold: [1] });

    loadMoreIntersectionObserver.observe(
        document.querySelector(".load-more-section")
    );
})