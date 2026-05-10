@extends('layouts.app')

@section('title', 'Pesan - VINTARA')

@section('content')
<div class="chat-page" style="padding: 0; background: #F3F0FF; min-height: 100vh;">
    <div class="chat-container" style="display: flex; max-width: 1400px; margin: 0 auto; background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); min-height: 85vh;">
        
        {{-- SIDEBAR KIRI: DAFTAR CHAT --}}
        <div class="chat-sidebar" style="width: 380px; background: white; border-right: 1px solid #e9ecef; display: flex; flex-direction: column;">
            
            {{-- HEADER SIDEBAR --}}
            <div class="chat-sidebar-header" style="padding: 20px; border-bottom: 1px solid #e9ecef;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="color: #1F1B5B; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-comment-dots"></i> Pesan
                        <span id="chatTotalCount" style="background: #F3F0FF; color: #1F1B5B; font-size: 12px; padding: 2px 8px; border-radius: 20px;">0</span>
                    </h3>
                    <div style="display: flex; gap: 12px;">
                        <i class="fas fa-ellipsis-v" style="color: #6c757d; cursor: pointer;"></i>
                    </div>
                </div>
                
                {{-- FILTER BUTTONS --}}
                <div style="display: flex; gap: 8px; margin-top: 15px;">
                    <button class="filter-btn active" data-filter="all" style="padding: 6px 16px; border-radius: 30px; border: none; background: #1F1B5B; color: white; font-size: 12px; cursor: pointer;">Semua</button>
                    <button class="filter-btn" data-filter="unread" style="padding: 6px 16px; border-radius: 30px; border: 1px solid #e9ecef; background: white; color: #6c757d; font-size: 12px; cursor: pointer;">Belum Dibaca</button>
                    <button class="filter-btn" data-filter="pinned" style="padding: 6px 16px; border-radius: 30px; border: 1px solid #e9ecef; background: white; color: #6c757d; font-size: 12px; cursor: pointer;">Disematkan</button>
                </div>
            </div>
            
            {{-- SEARCH BAR --}}
            <div style="padding: 15px 20px;">
                <div style="display: flex; align-items: center; background: #F8F9FA; border-radius: 30px; padding: 8px 16px;">
                    <i class="fas fa-search" style="color: #adb5bd; font-size: 14px;"></i>
                    <input type="text" id="searchChat" placeholder="Cari pesan..." 
                           style="border: none; background: transparent; flex: 1; margin-left: 10px; outline: none; font-size: 13px;">
                </div>
            </div>
            
            {{-- CHAT LIST --}}
            <div id="chatListContainer" style="flex: 1; overflow-y: auto; padding: 0 12px 20px 12px;">
                @php
                    $chats = App\Models\Chat::where('status', 'active')
                        ->orderBy('is_pinned', 'desc')
                        ->orderBy('last_message_time', 'desc')
                        ->get();
                @endphp
                
                @forelse($chats as $chat)
                <div class="chat-item" data-chat-id="{{ $chat->id }}" data-pinned="{{ $chat->is_pinned ? 'true' : 'false' }}" data-unread="{{ $chat->unread_count }}" style="display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 16px; margin-bottom: 8px; cursor: pointer; transition: all 0.3s;">
                    <div class="chat-avatar" style="position: relative;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">
                            {{ $chat->initial }}
                        </div>
                        @if($chat->unread_count > 0)
                        <div class="unread-badge" style="position: absolute; bottom: 0; right: 0; width: 18px; height: 18px; background: #ff4757; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: bold;">
                            {{ $chat->unread_count > 9 ? '9+' : $chat->unread_count }}
                        </div>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px;">
                            <h4 style="font-weight: 600; font-size: 14px; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $chat->shop_name }}
                                @if($chat->is_pinned)
                                <i class="fas fa-thumbtack" style="color: #ffc107; font-size: 11px; margin-left: 5px;"></i>
                                @endif
                            </h4>
                            <span style="font-size: 10px; color: #adb5bd;">{{ $chat->time_formatted }}</span>
                        </div>
                        <div style="font-size: 12px; color: {{ $chat->unread_count > 0 ? '#1F1B5B' : '#6c757d' }}; font-weight: {{ $chat->unread_count > 0 ? '600' : '400' }}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $chat->last_message_formatted }}
                        </div>
                    </div>
                    <div class="chat-actions" style="display: none;">
                        <i class="fas fa-ellipsis-v" style="color: #adb5bd;"></i>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 60px 20px;">
                    <i class="fas fa-comment-dots" style="font-size: 50px; color: #ccc;"></i>
                    <p style="margin-top: 15px; color: #6c757d;">Belum ada pesan</p>
                </div>
                @endforelse
            </div>
        </div>
        
        {{-- KONTEN KANAN: DETAIL CHAT --}}
        <div id="chatDetailContainer" style="flex: 1; display: flex; flex-direction: column; background: #F8F9FA;">
            {{-- Default state when no chat selected --}}
            <div id="defaultChatState" style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px;">
                <i class="fas fa-comment-dots" style="font-size: 70px; color: #1F1B5B; opacity: 0.3; margin-bottom: 20px;"></i>
                <h3 style="color: #1F1B5B; margin-bottom: 10px;">Percakapan Anda</h3>
                <p style="color: #6c757d; text-align: center; max-width: 300px;">Pilih percakapan dari daftar sebelah kiri untuk mulai chatting</p>
            </div>
            
            {{-- Chat detail will be loaded here --}}
            <div id="chatDetailContent" style="display: none; flex: 1; flex-direction: column; height: 100%;">
                {{-- Header chat --}}
                <div id="chatDetailHeader" style="padding: 15px 25px; background: white; border-bottom: 1px solid #e9ecef; display: flex; align-items: center; gap: 15px;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #1F1B5B, #3a3590); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                        <span id="chatInitial">V</span>
                    </div>
                    <div style="flex: 1;">
                        <h3 id="chatShopName" style="font-size: 16px; font-weight: 600; margin: 0;">Loading...</h3>
                        <div id="chatStatus" style="font-size: 11px; color: #28a745; margin-top: 3px;">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> Online
                        </div>
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <i id="pinChatBtn" class="fas fa-thumbtack" style="cursor: pointer; color: #6c757d;"></i>
                        <i id="archiveChatBtn" class="fas fa-archive" style="cursor: pointer; color: #6c757d;"></i>
                        <i id="deleteChatBtn" class="fas fa-trash-alt" style="cursor: pointer; color: #dc3545;"></i>
                    </div>
                </div>
                
                {{-- Messages container --}}
                <div id="messagesContainer" style="flex: 1; overflow-y: auto; padding: 20px;">
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-spinner fa-pulse"></i> Memuat pesan...
                    </div>
                </div>
                
                {{-- TYPING INDICATOR --}}
                <div id="typingIndicator" style="display: none; padding: 8px 20px; background: #F8F9FA;">
                    <div class="typing-indicator" style="display: inline-flex; align-items: center; gap: 8px; background: white; padding: 8px 15px; border-radius: 20px;">
                        <div class="typing-dots">
                            <span></span><span></span><span></span>
                        </div>
                        <span style="font-size: 12px; color: #6c757d;">Sedang mengetik...</span>
                    </div>
                </div>
                
                {{-- INPUT MESSAGE WITH ICONS (LENGKAP) --}}
                <div style="padding: 15px 20px; background: white; border-top: 1px solid #e9ecef;">
                    <div style="display: flex; gap: 10px; align-items: flex-end;">
                        
                        {{-- TOMBOL EMOJI --}}
                        <div style="position: relative;">
                            <button id="emojiBtn" type="button" style="width: 42px; height: 42px; background: #F3F0FF; border: none; border-radius: 50%; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                                <i class="far fa-smile-wink" style="font-size: 20px; color: #1F1B5B;"></i>
                            </button>
                            <div id="emojiPicker" style="display: none; position: absolute; bottom: 55px; left: 0; background: white; border-radius: 16px; box-shadow: 0 5px 20px rgba(0,0,0,0.15); padding: 12px; z-index: 100; width: 300px; max-height: 300px; overflow-y: auto;">
                                <div style="display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px;">
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">😀</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">😂</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">😍</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🥰</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">😘</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">❤️</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🔥</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">👍</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🎉</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">✨</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">💯</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🤣</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">😭</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">😎</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🤔</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🙏</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">💀</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🤡</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">👻</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🐱</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🐶</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🍕</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">🎂</span>
                                    <span class="emoji-item" style="font-size: 24px; cursor: pointer; text-align: center; padding: 5px; border-radius: 8px; transition: all 0.2s;">⚡</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- TOMBOL ATTACHMENT (GAMBAR) --}}
                        <div style="position: relative;">
                            <button id="attachBtn" type="button" style="width: 42px; height: 42px; background: #F3F0FF; border: none; border-radius: 50%; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-paperclip" style="font-size: 18px; color: #1F1B5B;"></i>
                            </button>
                            <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                        </div>
                        
                        {{-- TOMBOL VOICE/RECORD --}}
                        <button id="voiceBtn" type="button" style="width: 42px; height: 42px; background: #F3F0FF; border: none; border-radius: 50%; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-microphone" style="font-size: 18px; color: #1F1B5B;"></i>
                        </button>
                        
                        {{-- TEXTAREA PESAN --}}
                        <div style="flex: 1; background: #F8F9FA; border-radius: 25px; padding: 10px 18px;">
                            <textarea id="messageInput" rows="1" placeholder="Tulis pesan..." 
                                      style="width: 100%; border: none; background: transparent; resize: none; outline: none; font-family: inherit; font-size: 14px; max-height: 100px;"></textarea>
                        </div>
                        
                        {{-- TOMBOL KIRIM --}}
                        <button id="sendMessageBtn" style="width: 42px; height: 42px; background: #1F1B5B; border: none; border-radius: 50%; color: white; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-paper-plane" style="font-size: 16px;"></i>
                        </button>
                    </div>
                    
                    {{-- PREVIEW GAMBAR YANG AKAN DIKIRIM --}}
                    <div id="imagePreviewContainer" style="display: none; margin-top: 12px; padding: 10px; background: #F3F0FF; border-radius: 16px; position: relative;">
                        <img id="imagePreview" src="" alt="Preview" style="max-width: 100px; max-height: 100px; border-radius: 12px; object-fit: cover;">
                        <button id="cancelImageBtn" style="position: absolute; top: 5px; right: 5px; width: 25px; height: 25px; background: #ff4757; border: none; border-radius: 50%; color: white; cursor: pointer;">
                            <i class="fas fa-times" style="font-size: 12px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .chat-item:hover {
        background: #F3F0FF;
    }
    .chat-item.active {
        background: #F3F0FF;
        border-left: 3px solid #1F1B5B;
    }
    .filter-btn.active {
        background: #1F1B5B !important;
        color: white !important;
    }
    .message-bubble-user {
        background: #1F1B5B;
        color: white;
        border-radius: 20px 20px 5px 20px;
    }
    .message-bubble-shop {
        background: white;
        color: #333;
        border-radius: 20px 20px 20px 5px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .message-bubble-image {
        background: #F3F0FF;
        padding: 8px;
        border-radius: 16px;
    }
    .message-bubble-image img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        cursor: pointer;
    }
    .emoji-item:hover {
        background: #F3F0FF;
        transform: scale(1.1);
    }
    .typing-indicator .typing-dots {
        display: inline-flex;
        gap: 4px;
    }
    .typing-indicator .typing-dots span {
        width: 6px;
        height: 6px;
        background: #1F1B5B;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }
    .typing-indicator .typing-dots span:nth-child(1) { animation-delay: 0s; }
    .typing-indicator .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator .typing-dots span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
        30% { transform: translateY(-6px); opacity: 1; }
    }
    .notification-chat {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        z-index: 9999;
        transform: translateX(450px);
        transition: transform 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .notification-chat.error {
        background: #ff4757;
    }
    .notification-chat.show {
        transform: translateX(0);
    }
    #messageInput {
        overflow-y: auto;
        line-height: 1.4;
    }
    .voice-recording {
        animation: pulse 1s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); background: #ff4757; }
        50% { transform: scale(1.1); background: #ff6b81; }
        100% { transform: scale(1); background: #ff4757; }
    }
</style>

<script>
    let currentChatId = null;
    let typingTimeout = null;
    let isTyping = false;
    let selectedImageFile = null;
    let isRecording = false;
    let mediaRecorder = null;
    let audioChunks = [];
    
    function formatRupiah(price) {
        if (!price && price !== 0) return 'Rp 0';
        return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function showChatNotification(message, isError = false) {
        const oldNotif = document.querySelector('.notification-chat');
        if (oldNotif) oldNotif.remove();
        
        const notification = document.createElement('div');
        notification.className = 'notification-chat';
        if (isError) notification.classList.add('error');
        notification.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    // ==================== EMOJI PICKER ====================
    function initEmojiPicker() {
        const emojiBtn = document.getElementById('emojiBtn');
        const emojiPicker = document.getElementById('emojiPicker');
        const messageInput = document.getElementById('messageInput');
        
        if (emojiBtn && emojiPicker) {
            emojiBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
            });
            
            document.querySelectorAll('.emoji-item').forEach(emoji => {
                emoji.addEventListener('click', function() {
                    const emojiChar = this.textContent;
                    const cursorPos = messageInput.selectionStart;
                    const text = messageInput.value;
                    messageInput.value = text.slice(0, cursorPos) + emojiChar + text.slice(cursorPos);
                    messageInput.focus();
                    emojiPicker.style.display = 'none';
                    autoResizeTextarea();
                });
            });
            
            document.addEventListener('click', function(e) {
                if (!emojiPicker.contains(e.target) && e.target !== emojiBtn) {
                    emojiPicker.style.display = 'none';
                }
            });
        }
    }
    
    // ==================== IMAGE UPLOAD ====================
    function initImageUpload() {
        const attachBtn = document.getElementById('attachBtn');
        const imageUpload = document.getElementById('imageUpload');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const cancelImageBtn = document.getElementById('cancelImageBtn');
        
        if (attachBtn && imageUpload) {
            attachBtn.addEventListener('click', function() {
                imageUpload.click();
            });
            
            imageUpload.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    selectedImageFile = file;
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.src = event.target.result;
                        imagePreviewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            if (cancelImageBtn) {
                cancelImageBtn.addEventListener('click', function() {
                    selectedImageFile = null;
                    imageUpload.value = '';
                    imagePreviewContainer.style.display = 'none';
                    imagePreview.src = '';
                });
            }
        }
    }
    
    // ==================== VOICE RECORDING ====================
    function initVoiceRecording() {
        const voiceBtn = document.getElementById('voiceBtn');
        
        if (voiceBtn) {
            voiceBtn.addEventListener('click', async function() {
                if (!isRecording) {
                    // Start recording
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        mediaRecorder = new MediaRecorder(stream);
                        audioChunks = [];
                        
                        mediaRecorder.ondataavailable = event => {
                            audioChunks.push(event.data);
                        };
                        
                        mediaRecorder.onstop = () => {
                            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                            // Simulate sending voice message
                            showChatNotification('Voice message recorded! (Demo)');
                            voiceBtn.style.background = '#F3F0FF';
                            voiceBtn.style.color = '#1F1B5B';
                            isRecording = false;
                            
                            // Stop all tracks
                            stream.getTracks().forEach(track => track.stop());
                        };
                        
                        mediaRecorder.start();
                        isRecording = true;
                        voiceBtn.style.background = '#ff4757';
                        voiceBtn.style.color = 'white';
                        voiceBtn.classList.add('voice-recording');
                        showChatNotification('Recording... Click again to stop');
                        
                        // Auto stop after 30 seconds
                        setTimeout(() => {
                            if (mediaRecorder && mediaRecorder.state === 'recording') {
                                mediaRecorder.stop();
                            }
                        }, 30000);
                        
                    } catch (err) {
                        console.error('Microphone error:', err);
                        showChatNotification('Microphone access denied!', true);
                    }
                } else {
                    // Stop recording
                    if (mediaRecorder && mediaRecorder.state === 'recording') {
                        mediaRecorder.stop();
                        voiceBtn.classList.remove('voice-recording');
                    }
                }
            });
        }
    }
    
    // ==================== SEND MESSAGE WITH IMAGE ====================
    async function sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        
        if (!message && !selectedImageFile) {
            showChatNotification('Pesan tidak boleh kosong!', true);
            return;
        }
        
        if (!currentChatId) {
            showChatNotification('Pilih percakapan terlebih dahulu!', true);
            return;
        }
        
        const sendBtn = document.getElementById('sendMessageBtn');
        sendBtn.disabled = true;
        sendBtn.style.opacity = '0.5';
        
        try {
            // If there's an image, send as image message
            if (selectedImageFile) {
                // Simulate image upload (in real implementation, upload to server)
                const reader = new FileReader();
                reader.onload = async function(event) {
                    const imageData = event.target.result;
                    const imageMessage = message ? `📷 ${message}` : '📷 Mengirim gambar';
                    
                    // Send message with image
                    const response = await fetch(`/api/chat/${currentChatId}/send`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ message: imageMessage, image: imageData })
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        input.value = '';
                        selectedImageFile = null;
                        document.getElementById('imagePreviewContainer').style.display = 'none';
                        document.getElementById('imageUpload').value = '';
                        
                        // Add image message to UI
                        addImageMessageToUI(imageData, message);
                        scrollToBottom();
                        showChatNotification('Gambar terkirim!');
                    }
                };
                reader.readAsDataURL(selectedImageFile);
            } else {
                // Send text message
                const response = await fetch(`/api/chat/${currentChatId}/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: message })
                });
                
                const data = await response.json();
                if (data.success) {
                    input.value = '';
                    addMessageToUI(message);
                    scrollToBottom();
                    showChatNotification('Pesan terkirim!');
                } else {
                    showChatNotification('Gagal mengirim pesan', true);
                }
            }
        } catch (error) {
            console.error('Error sending message:', error);
            showChatNotification('Gagal mengirim pesan', true);
        } finally {
            sendBtn.disabled = false;
            sendBtn.style.opacity = '1';
            autoResizeTextarea();
        }
    }
    
    function addMessageToUI(message) {
        const container = document.getElementById('messagesContainer');
        const messageHtml = `
            <div class="message-item user-message" style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                <div class="message-bubble-user" style="max-width: 70%; padding: 10px 15px; background: #1F1B5B; color: white; border-radius: 20px 20px 5px 20px;">
                    <p style="margin: 0; font-size: 13px; line-height: 1.4;">${escapeHtml(message)}</p>
                    <p style="margin: 5px 0 0; font-size: 9px; opacity: 0.7; text-align: right;">${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} <i class="fas fa-check-double"></i></p>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', messageHtml);
    }
    
    function addImageMessageToUI(imageData, caption) {
        const container = document.getElementById('messagesContainer');
        const messageHtml = `
            <div class="message-item user-message" style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                <div class="message-bubble-user" style="max-width: 70%; padding: 10px; background: #1F1B5B; color: white; border-radius: 20px 20px 5px 20px;">
                    <img src="${imageData}" alt="Image" style="max-width: 200px; max-height: 200px; border-radius: 12px; margin-bottom: 5px; cursor: pointer;" onclick="window.open(this.src)">
                    ${caption ? `<p style="margin: 5px 0 0; font-size: 12px;">${escapeHtml(caption)}</p>` : ''}
                    <p style="margin: 5px 0 0; font-size: 9px; opacity: 0.7; text-align: right;">${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} <i class="fas fa-check-double"></i></p>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', messageHtml);
    }
    
    // ==================== LOAD CHAT DETAIL ====================
    function loadChatDetail(chatId) {
        currentChatId = chatId;
        
        document.querySelectorAll('.chat-item').forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-chat-id') == chatId) {
                item.classList.add('active');
            }
        });
        
        document.getElementById('defaultChatState').style.display = 'none';
        document.getElementById('chatDetailContent').style.display = 'flex';
        
        fetch(`/api/chat/${chatId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chat = data.data;
                    document.getElementById('chatShopName').textContent = chat.shop_name;
                    document.getElementById('chatInitial').textContent = chat.initial;
                    
                    const pinBtn = document.getElementById('pinChatBtn');
                    if (chat.is_pinned) {
                        pinBtn.style.color = '#ffc107';
                    } else {
                        pinBtn.style.color = '#6c757d';
                    }
                    
                    const chatItem = document.querySelector(`.chat-item[data-chat-id="${chatId}"]`);
                    if (chatItem) {
                        const unreadBadge = chatItem.querySelector('.unread-badge');
                        if (unreadBadge) unreadBadge.remove();
                        chatItem.setAttribute('data-unread', '0');
                    }
                    
                    renderMessages(chat.messages);
                }
            })
            .catch(error => {
                console.error('Error loading chat:', error);
                showChatNotification('Gagal memuat pesan', true);
            });
    }
    
    function renderMessages(messages) {
        const container = document.getElementById('messagesContainer');
        
        if (!messages || messages.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-comment" style="font-size: 40px; color: #ccc;"></i>
                    <p style="margin-top: 15px; color: #6c757d;">Belum ada pesan</p>
                    <p style="font-size: 12px; color: #adb5bd;">Mulai percakapan dengan mengirim pesan</p>
                </div>
            `;
            return;
        }
        
        let lastDate = null;
        let html = '';
        
        messages.forEach(msg => {
            const msgDate = new Date(msg.created_at).toLocaleDateString('id-ID');
            if (lastDate !== msgDate) {
                html += `
                    <div style="text-align: center; margin: 20px 0 15px;">
                        <span style="background: #e9ecef; padding: 4px 12px; border-radius: 20px; font-size: 11px; color: #6c757d;">${msgDate}</span>
                    </div>
                `;
                lastDate = msgDate;
            }
            
            // Check if message contains image
            const isImage = msg.message && msg.message.includes('📷');
            
            if (msg.sender === 'user') {
                if (isImage) {
                    html += `
                        <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                            <div class="message-bubble-user" style="max-width: 70%; padding: 10px; background: #1F1B5B; border-radius: 20px 20px 5px 20px;">
                                <i class="fas fa-image" style="margin-right: 5px;"></i> ${escapeHtml(msg.message)}
                                <p style="margin: 5px 0 0; font-size: 9px; opacity: 0.7; text-align: right;">
                                    ${formatTime(msg.created_at)}
                                    ${msg.is_read ? '<i class="fas fa-check-double"></i>' : '<i class="fas fa-check"></i>'}
                                </p>
                            </div>
                        </div>
                    `;
                } else {
                    html += `
                        <div style="display: flex; justify-content: flex-end; margin-bottom: 12px;">
                            <div class="message-bubble-user" style="max-width: 70%; padding: 10px 15px; background: #1F1B5B; color: white; border-radius: 20px 20px 5px 20px;">
                                <p style="margin: 0; font-size: 13px; line-height: 1.4;">${escapeHtml(msg.message)}</p>
                                <p style="margin: 5px 0 0; font-size: 9px; opacity: 0.7; text-align: right;">
                                    ${formatTime(msg.created_at)}
                                    ${msg.is_read ? '<i class="fas fa-check-double"></i>' : '<i class="fas fa-check"></i>'}
                                </p>
                            </div>
                        </div>
                    `;
                }
            } else {
                html += `
                    <div style="display: flex; justify-content: flex-start; margin-bottom: 12px;">
                        <div class="message-bubble-shop" style="max-width: 70%; padding: 10px 15px; background: white; color: #333; border-radius: 20px 20px 20px 5px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                            <p style="margin: 0; font-size: 13px; line-height: 1.4;">${escapeHtml(msg.message)}</p>
                            <p style="margin: 5px 0 0; font-size: 9px; color: #adb5bd; text-align: left;">
                                ${formatTime(msg.created_at)}
                                ${msg.is_read ? '<i class="fas fa-check-double" style="margin-left: 8px;"></i>' : '<i class="fas fa-check" style="margin-left: 8px;"></i>'}
                            </p>
                        </div>
                    </div>
                `;
            }
        });
        
        container.innerHTML = html;
        scrollToBottom();
    }
    
    function formatTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }
    
    function scrollToBottom() {
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }
    
    function autoResizeTextarea() {
        const textarea = document.getElementById('messageInput');
        if (textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 100) + 'px';
        }
    }
    
    // ==================== TYPING INDICATOR ====================
    function initTypingIndicator() {
        const messageInput = document.getElementById('messageInput');
        const typingIndicator = document.getElementById('typingIndicator');
        
        if (messageInput) {
            messageInput.addEventListener('input', function() {
                if (!isTyping) {
                    isTyping = true;
                    if (typingIndicator) typingIndicator.style.display = 'block';
                    
                    // Simulate typing (shop is typing)
                    setTimeout(() => {
                        if (typingIndicator) typingIndicator.style.display = 'none';
                        isTyping = false;
                    }, 2000);
                }
                
                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => {
                    if (typingIndicator) typingIndicator.style.display = 'none';
                    isTyping = false;
                }, 1000);
            });
        }
    }
    
    // ==================== PIN, ARCHIVE, DELETE ====================
    function togglePinChat() {
        if (!currentChatId) return;
        
        fetch(`/api/chat/${currentChatId}/pin`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const pinBtn = document.getElementById('pinChatBtn');
                if (data.is_pinned) {
                    pinBtn.style.color = '#ffc107';
                    showChatNotification('Chat disematkan');
                } else {
                    pinBtn.style.color = '#6c757d';
                    showChatNotification('Chat dilepaskan');
                }
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error pinning chat:', error);
            showChatNotification('Gagal menyematkan chat', true);
        });
    }
    
    function archiveChat() {
        if (!currentChatId) return;
        
        if (confirm('Arsipkan percakapan ini?')) {
            fetch(`/api/chat/${currentChatId}/archive`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showChatNotification('Chat diarsipkan');
                    setTimeout(() => {
                        window.location.href = '/chat';
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error archiving chat:', error);
                showChatNotification('Gagal mengarsipkan chat', true);
            });
        }
    }
    
    function deleteChat() {
        if (!currentChatId) return;
        
        if (confirm('Hapus percakapan ini? Tindakan ini tidak dapat dibatalkan!')) {
            fetch(`/api/chat/${currentChatId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showChatNotification('Chat dihapus');
                    setTimeout(() => {
                        window.location.href = '/chat';
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error deleting chat:', error);
                showChatNotification('Gagal menghapus chat', true);
            });
        }
    }
    
    // ==================== FILTER & SEARCH ====================
    function filterChats(filter) {
        const chatItems = document.querySelectorAll('.chat-item');
        
        chatItems.forEach(item => {
            const isPinned = item.getAttribute('data-pinned') === 'true';
            const unreadCount = parseInt(item.getAttribute('data-unread') || '0');
            
            if (filter === 'all') {
                item.style.display = 'flex';
            } else if (filter === 'unread') {
                item.style.display = unreadCount > 0 ? 'flex' : 'none';
            } else if (filter === 'pinned') {
                item.style.display = isPinned ? 'flex' : 'none';
            }
        });
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-filter') === filter) {
                btn.classList.add('active');
                btn.style.background = '#1F1B5B';
                btn.style.color = 'white';
            } else {
                btn.style.background = 'white';
                btn.style.color = '#6c757d';
            }
        });
    }
    
    function searchChats(keyword) {
        const chatItems = document.querySelectorAll('.chat-item');
        const lowerKeyword = keyword.toLowerCase();
        
        chatItems.forEach(item => {
            const shopName = item.querySelector('h4').textContent.toLowerCase();
            const lastMessage = item.querySelector('.chat-item-info div:last-child').textContent.toLowerCase();
            
            if (shopName.includes(lowerKeyword) || lastMessage.includes(lowerKeyword)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    function updateChatBadge() {
        const totalChats = document.querySelectorAll('.chat-item').length;
        const badge = document.getElementById('chatTotalCount');
        if (badge) {
            badge.textContent = totalChats;
        }
    }
    
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', function() {
        initEmojiPicker();
        initImageUpload();
        initVoiceRecording();
        initTypingIndicator();
        
        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', function(e) {
                const chatId = this.getAttribute('data-chat-id');
                loadChatDetail(chatId);
            });
        });
        
        const sendBtn = document.getElementById('sendMessageBtn');
        if (sendBtn) {
            sendBtn.addEventListener('click', sendMessage);
        }
        
        const messageInput = document.getElementById('messageInput');
        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            messageInput.addEventListener('input', autoResizeTextarea);
        }
        
        const pinBtn = document.getElementById('pinChatBtn');
        if (pinBtn) pinBtn.addEventListener('click', togglePinChat);
        
        const archiveBtn = document.getElementById('archiveChatBtn');
        if (archiveBtn) archiveBtn.addEventListener('click', archiveChat);
        
        const deleteBtn = document.getElementById('deleteChatBtn');
        if (deleteBtn) deleteBtn.addEventListener('click', deleteChat);
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                filterChats(filter);
            });
        });
        
        const searchInput = document.getElementById('searchChat');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                searchChats(e.target.value);
            });
        }
        
        updateChatBadge();
        
        const urlParams = new URLSearchParams(window.location.search);
        const chatId = urlParams.get('id');
        if (chatId) {
            loadChatDetail(chatId);
        }
    });
</script>
@endsection