@extends($layout)


@section('content')
    <div class="content-wrapper">
        <section class="content mt-5">
            <div class="container-fluid">
                <h2>Переписка з {{ $otherUser->name }}</h2>

                <div class="chat-box mt-4 mb-4" id="chat-box" style="max-height: 500px; overflow-y: auto;">
                </div>

                <form id="sendMessageForm">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" placeholder="Напишіть повідомлення..." rows="3"
                                  required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Відправити</button>
                </form>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatBox = document.querySelector('.chat-box');
            const messageForm = document.getElementById('sendMessageForm');
            const receiverId = {{ $otherUser->id }}; // ID второго пользователя

            // Получаем CSRF-токен
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error("CSRF-токен не найден!");
                return;
            }

            // Функция для загрузки сообщений
            async function fetchMessages() {
                try {
                    const response = await fetch(`/messages/fetch/${receiverId}`);
                    const messages = await response.json();

                    if (response.ok) {
                        chatBox.innerHTML = '';
                        messages.forEach(message => {
                            const messageElement = document.createElement('div');
                            messageElement.className = 'message';
                            messageElement.classList.add(message.sender_id === {{ auth()->id() }} ? 'text-right' : 'text-left');
                            messageElement.innerHTML = `
                        <p><strong>${message.sender_id === {{ auth()->id() }} ? 'Ви' : '{{ $otherUser->name }}'}:</strong> ${message.content}</p>
                        <small>${new Date(message.created_at).toLocaleTimeString()}</small>
                    `;
                            chatBox.appendChild(messageElement);
                        });
                        chatBox.scrollTop = chatBox.scrollHeight;
                    } else {
                        console.error('Ошибка загрузки сообщений');
                    }
                } catch (error) {
                    console.error('Ошибка:', error);
                }
            }

            // Обновление сообщений каждые 3 секунды
            setInterval(fetchMessages, 3000);
            fetchMessages(); // Первый вызов для инициализации

            // Обработчик отправки сообщения
            messageForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const content = this.content.value.trim();
                if (!content) return;

                try {
                    const response = await fetch(`/messages/conversation/send/${receiverId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({content})
                    });

                    if (response.ok) {
                        this.content.value = ''; // Очистить поле ввода
                        fetchMessages(); // Обновить сообщения
                    } else {
                        console.error('Ошибка отправки сообщения');
                    }
                } catch (error) {
                    console.error('Ошибка:', error);
                }
            });
        });


    </script>
@endsection
