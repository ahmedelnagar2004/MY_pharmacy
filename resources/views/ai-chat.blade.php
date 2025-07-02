<x-user-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="fas fa-robot me-2"></i>مساعد الذكاء الاصطناعي الطبي
                    </div>
                    <div class="card-body">
                        <form id="ai-form" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="question" class="form-control" placeholder="اسأل عن أي شيء طبي..." required>
                                <button type="submit" class="btn btn-primary">اسأل</button>
                            </div>
                        </form>
                        <div id="ai-answer" class="alert alert-info d-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('ai-form').onsubmit = async function(e) {
        e.preventDefault();
        let question = this.question.value;
        let answerDiv = document.getElementById('ai-answer');
        answerDiv.classList.add('d-none');
        answerDiv.innerText = 'جاري التحميل...';
        answerDiv.classList.remove('alert-danger');
        try {
            let res = await fetch("{{ route('ai.ask') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({question})
            });
            let data = await res.json();
            answerDiv.innerText = data.answer;
            answerDiv.classList.remove('d-none');
        } catch (err) {
            answerDiv.innerText = 'حدث خطأ أثناء الاتصال بالذكاء الاصطناعي.';
            answerDiv.classList.remove('d-none');
            answerDiv.classList.add('alert-danger');
        }
    };
    </script>
</x-user-layout> 