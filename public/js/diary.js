$( function() {

    $(document).on('click', '.js-like', function() {
        let diaryId = $(this).siblings('.diary-id').val();

        let $clickedBtn = $(this);

        like(diaryId, $clickedBtn);
    })

    $(document).on('click', '.js-dislike', function() {
        let diaryId = $(this).siblings('.diary-id').val();

        let $clickedBtn = $(this);

        dislike(diaryId, $clickedBtn);
    })

    
    // いいね
    function like(diaryId, $clickedBtn) {
        $.ajax({
            url: 'diary/' + diaryId +'/like',
            type: 'POST',
            dataTyupe: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(
            function (data) {
                changeLikeBtn($clickedBtn);
                
                // いいね数を1増やす
                let num = Number($clickedBtn.siblings('.js-like-num').text());
                $clickedBtn.siblings('.js-like-num').text(num + 1);
            },
            function () {
                console.log(error);
            }
        )
    }

    // いいね解除
    function dislike(diaryId, $clickedBtn) {
        $.ajax({
            url: 'diary/' + diaryId +'/dislike',
            type: 'POST',
            dataTyupe: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(
            function (data) {
                changeLikeBtn($clickedBtn);

                // いいね数を1減らす
                let num = Number($clickedBtn.siblings('.js-like-num').text());
                $clickedBtn.siblings('.js-like-num').text(num - 1);
            },
            function () {
                console.log(error);
            }
        )
    }

    //いいね, いいね解除の見た目切り替え
    function changeLikeBtn(btn) {
        btn.toggleClass('far');
        btn.toggleClass('fas');
        btn.toggleClass('js-like');
        btn.toggleClass('js-dislike');
    }
});