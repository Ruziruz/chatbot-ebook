    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Buku Elektronik x ChatGPT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #006d5b;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        }

        .chat-container {
        text-align: center;
        max-width: 1000px;
        width: 100%;
        }

        h1 {
        font-size: 24px;
        margin-bottom: 10px;
        }

        h2 {
        font-size: 18px;
        font-weight: normal;
        margin-bottom: 20px;
        }

        textarea {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: none;
        font-size: 16px;
        margin-bottom: 15px;
        resize: both;
        max-width: 1000px;
        overflow: hidden;
        transition: height 0.2s ease, width 0.2s ease;
        }

        textarea.auto-resize {
        width: auto;
        max-width: 100%;
        height: auto;
        overflow-y: hidden;
        }

        textarea:focus {
        overflow-y: auto;
        resize: both;
        }

        button {
        background-color: #00a582;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 15px;
        }

        button:hover {
        background-color: #008f6f;
        }

        form {
        display: flex;
        flex-direction: column;
        align-items: center;
        }
    </style>
    </head>

    <body>
    <div class="chat-container">
        <h1>Halo, apa yang ingin kamu tanyakan?</h1>
        <h2>Buku Elektronik x ChatGPT</h2>
        <form id="chat-form">
        <textarea id="message" name="message" rows="5" placeholder="Tulis di sini..." required></textarea>
        <button type="submit">Tanya</button>
        </form>
    </div>

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        const form = document.getElementById('chat-form');
        const messageInput = document.getElementById('message');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Auto-resize textarea
        messageInput.addEventListener('input', () => {
            messageInput.style.height = 'auto'; // Reset height untuk menghitung ulang
            messageInput.style.height = `${messageInput.scrollHeight}px`; // Sesuaikan dengan konten
        });

        // Cek apakah ada jawaban yang tersimpan di localStorage
        document.addEventListener('DOMContentLoaded', () => {
            const savedReply = localStorage.getItem('chatReply');
            if (savedReply) {
                messageInput.value = savedReply; // Masukkan jawaban ke kolom teks
                localStorage.removeItem('chatReply'); // Hapus jawaban setelah dimasukkan
            }
            messageInput.style.height = 'auto'; // Reset height
            messageInput.style.height = `${messageInput.scrollHeight}px`; // Sesuaikan dengan konten
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const userMessage = messageInput.value.trim();

            if (!userMessage) return;

            try {
                const response = await fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ message: userMessage }),
                });

                const data = await response.json();

                if (data.reply) {
                    // Simpan jawaban ke localStorage dan refresh halaman
                    localStorage.setItem('chatReply', data.reply);
                    window.location.reload();
                }
            } catch (error) {
                messageInput.value = 'Error: Gagal mendapatkan respons.';
            }
        });
    </script>
    </body>
    </html>
