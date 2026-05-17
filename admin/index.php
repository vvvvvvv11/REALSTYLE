<?php
require_once 'config.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REALSTYLE Admin - Управление</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
            color: #1a1a1a;
        }
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .admin-header {
            background: #fff;
            border-radius: 20px;
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .admin-header h1 {
            font-size: 24px;
            font-weight: 700;
        }
        .admin-header h1 span {
            color: #6B6B6B;
            font-weight: 400;
            font-size: 14px;
        }
        .logout-btn {
            background: #1a1a1a;
            color: #fff;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: opacity 0.15s;
        }
        .logout-btn:hover { opacity: 0.8; }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            background: #f0f0f0;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-icon span { font-size: 28px; }
        .stat-info h3 { font-size: 28px; font-weight: 700; }
        .stat-info p { color: #6B6B6B; font-size: 14px; }
        
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .tab-btn {
            padding: 12px 24px;
            background: #fff;
            border: none;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }
        .tab-btn.active {
            background: #1a1a1a;
            color: #fff;
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .content-card {
            background: #fff;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            font-weight: 600;
            color: #6B6B6B;
            font-size: 13px;
        }
        .status-badge {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-new { background: #FFF3E0; color: #E65100; }
        .status-at_warehouse { background: #FFF8E1; color: #F9A825; }
        .status-in_delivery { background: #E3F2FD; color: #1565C0; }
        .status-arrived { background: #E8F5E9; color: #2E7D32; }
        .status-completed { background: #E8F5E9; color: #2E7D32; }
        .status-cancelled { background: #FFEBEE; color: #C62828; }
        
        .select-status {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
            background: #fff;
            cursor: pointer;
        }
        .delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #C62828;
            padding: 4px 8px;
            border-radius: 8px;
        }
        .delete-btn:hover { background: #FFEBEE; }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .gallery-item {
            background: #f9f9f9;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
        }
        .gallery-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .gallery-item-info {
            padding: 12px;
        }
        .gallery-item-title {
            font-weight: 600;
            margin-bottom: 4px;
        }
        .gallery-item-subtitle {
            font-size: 12px;
            color: #6B6B6B;
        }
        .gallery-item-actions {
            display: flex;
            justify-content: flex-end;
            padding: 8px 12px 12px;
            gap: 8px;
        }
        
        .add-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 16px;
            margin-top: 20px;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-field label {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
        }
        .form-field input, .form-field textarea {
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
        }
        .form-field input:focus, .form-field textarea:focus {
            outline: none;
            border-color: #1a1a1a;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.15s;
        }
        .btn-primary {
            background: #1a1a1a;
            color: #fff;
        }
        .btn-primary:hover { opacity: 0.8; }
        
        .reviews-list, .faq-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .review-item, .faq-item {
            background: #f9f9f9;
            border-radius: 16px;
            padding: 16px;
        }
        .review-header, .faq-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .review-author {
            font-weight: 700;
        }
        .review-stars {
            display: flex;
            gap: 2px;
            margin-top: 4px;
        }
        .review-text, .faq-question-text {
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .faq-answer-text {
            color: #6B6B6B;
            font-size: 14px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #eee;
        }
        
        .loading {
            text-align: center;
            padding: 40px;
            color: #6B6B6B;
        }
        
        @media (max-width: 768px) {
            .admin-container { padding: 16px; }
            th, td { padding: 10px 8px; font-size: 13px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>REALSTYLE <span>Админ-панель</span></h1>
            <a href="logout.php" class="logout-btn">Выйти</a>
        </div>
        
        <div class="stats-grid" id="statsGrid">
            <div class="stat-card">
                <div class="stat-icon"><span class="material-symbols-outlined">shopping_bag</span></div>
                <div class="stat-info"><h3 id="totalOrders">-</h3><p>Всего заказов</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><span class="material-symbols-outlined">pending</span></div>
                <div class="stat-info"><h3 id="pendingOrders">-</h3><p>Активных заказов</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><span class="material-symbols-outlined">attach_money</span></div>
                <div class="stat-info"><h3 id="totalRevenue">-</h3><p>Выручка</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><span class="material-symbols-outlined">image</span></div>
                <div class="stat-info"><h3 id="galleryCount">-</h3><p>Фото в галерее</p></div>
            </div>
        </div>
        
        <div class="tabs">
            <button class="tab-btn active" data-tab="orders">📦 Заказы</button>
            <button class="tab-btn" data-tab="gallery">🖼️ Галерея</button>
            <button class="tab-btn" data-tab="reviews">⭐ Отзывы</button>
            <button class="tab-btn" data-tab="faq">❓ FAQ</button>
        </div>
        
        <!-- Заказы -->
        <div id="tab-orders" class="tab-content active">
            <div class="content-card">
                <div style="overflow-x: auto;">
                    <table id="ordersTable">
                        <thead>
                            <tr><th>ID</th><th>Заказ</th><th>Ссылка</th><th>Цена (¥)</th><th>Итого ($)</th><th>Статус</th><th>Дата</th><th>Действия</th></tr>
                        </thead>
                        <tbody id="ordersList"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Галерея -->
        <div id="tab-gallery" class="tab-content">
            <div class="content-card">
                <h3 style="margin-bottom: 20px;">Управление галереей</h3>
                <div id="galleryGrid" class="gallery-grid"></div>
                
                <div class="add-form">
                    <h4 style="margin-bottom: 16px;">➕ Добавить фото</h4>
                    <form id="addGalleryForm" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-field">
                                <label>Изображение *</label>
                                <input type="file" name="image" accept="image/*" required>
                            </div>
                            <div class="form-field">
                                <label>Заголовок</label>
                                <input type="text" name="title" placeholder="Например: China">
                            </div>
                            <div class="form-field">
                                <label>Подзаголовок</label>
                                <input type="text" name="subtitle" placeholder="Например: SPRING SALE ?">
                            </div>
                            <div class="form-field">
                                <label>Ссылка</label>
                                <input type="url" name="link" placeholder="https://...">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Отзывы -->
        <div id="tab-reviews" class="tab-content">
            <div class="content-card">
                <h3 style="margin-bottom: 20px;">Управление отзывами</h3>
                <div id="reviewsList" class="reviews-list"></div>
                
                <div class="add-form">
                    <h4 style="margin-bottom: 16px;">➕ Добавить отзыв</h4>
                    <form id="addReviewForm">
                        <div class="form-row">
                            <div class="form-field">
                                <label>Имя *</label>
                                <input type="text" name="author" required>
                            </div>
                            <div class="form-field">
                                <label>Рейтинг (1-5) *</label>
                                <input type="number" name="rating" min="1" max="5" required>
                            </div>
                        </div>
                        <div class="form-field">
                            <label>Текст отзыва *</label>
                            <textarea name="text" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить отзыв</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- FAQ -->
        <div id="tab-faq" class="tab-content">
            <div class="content-card">
                <h3 style="margin-bottom: 20px;">Управление FAQ</h3>
                <div id="faqList" class="faq-list"></div>
                
                <div class="add-form">
                    <h4 style="margin-bottom: 16px;">➕ Добавить вопрос</h4>
                    <form id="addFaqForm">
                        <div class="form-field" style="margin-bottom: 16px;">
                            <label>Вопрос *</label>
                            <input type="text" name="question" required>
                        </div>
                        <div class="form-field" style="margin-bottom: 16px;">
                            <label>Ответ *</label>
                            <textarea name="answer" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить вопрос</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        async function fetchAPI(url, options = {}) {
            try {
                const response = await fetch(url, options);
                return await response.json();
            } catch(e) {
                console.error('API error:', e);
                return { success: false, error: e.message };
            }
        }
        
        async function loadStats() {
            const data = await fetchAPI('api/get_stats.php');
            if (data.success) {
                document.getElementById('totalOrders').innerText = data.total_orders || 0;
                document.getElementById('pendingOrders').innerText = data.pending_orders || 0;
                document.getElementById('totalRevenue').innerText = '$' + (data.total_revenue || 0);
                document.getElementById('galleryCount').innerText = data.gallery_count || 0;
            }
        }
        
        async function loadOrders() {
            const data = await fetchAPI('api/get_orders.php');
            const tbody = document.getElementById('ordersList');
            if (!data.success || !data.orders || data.orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:40px;">Нет заказов</td></tr>';
                return;
            }
            tbody.innerHTML = data.orders.map(order => `
                <tr>
                    <td>${order.id}</td>
                    <td><strong>${order.title || 'Новый заказ'}</strong><br><small>Размер: ${order.size || '-'}</small><br><small>${order.comment ? order.comment.substring(0, 30) + (order.comment.length > 30 ? '...' : '') : '-'}</small></td>
                    <td><a href="${order.link}" target="_blank" style="color:#1565C0;">Открыть</a></td>
                    <td>${order.price_cny || '-'} ¥</td>
                    <td>$${order.amount || 0}</td>
                    <td>
                        <select class="select-status" data-id="${order.id}" data-status="${order.status}" onchange="updateOrderStatus(${order.id}, this.value)">
                            <option value="new" ${order.status === 'new' ? 'selected' : ''}>🆕 Новый</option>
                            <option value="at_warehouse" ${order.status === 'at_warehouse' ? 'selected' : ''}>📦 На складе</option>
                            <option value="in_delivery" ${order.status === 'in_delivery' ? 'selected' : ''}>✈️ В доставке</option>
                            <option value="arrived" ${order.status === 'arrived' ? 'selected' : ''}>📍 Прибыл</option>
                            <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>✅ Завершён</option>
                            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>❌ Отменён</option>
                        </select>
                    </td>
                    <td>${new Date(order.created_at).toLocaleDateString()}</td>
                    <td><button class="delete-btn" onclick="deleteOrder(${order.id})"><span class="material-symbols-outlined">delete</span></button></td>
                </tr>
            `).join('');
        }
        
        window.updateOrderStatus = async function(id, status) {
            const result = await fetchAPI('api/update_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status })
            });
            if (result.success) {
                loadOrders();
                loadStats();
                showToast('Статус обновлён');
            } else {
                showToast('Ошибка обновления', true);
            }
        };
        
        window.deleteOrder = async function(id) {
            if (!confirm('Удалить заказ?')) return;
            const result = await fetchAPI('api/delete_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            if (result.success) {
                loadOrders();
                loadStats();
                showToast('Заказ удалён');
            } else {
                showToast('Ошибка удаления', true);
            }
        };
        
        async function loadGallery() {
            const data = await fetchAPI('api/get_gallery.php');
            const container = document.getElementById('galleryGrid');
            if (!data.success || !data.items || data.items.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding:40px;">Нет фото</div>';
                return;
            }
            container.innerHTML = data.items.map(item => `
                <div class="gallery-item">
                    <img src="${item.image_url}" alt="${item.title || ''}" onerror="this.src='https://placehold.co/400x300?text=No+Image'">
                    <div class="gallery-item-info">
                        <div class="gallery-item-title">${item.title || 'Без названия'}</div>
                        <div class="gallery-item-subtitle">${item.subtitle || ''}</div>
                    </div>
                    <div class="gallery-item-actions">
                        <button class="delete-btn" onclick="deleteGalleryItem(${item.id})"><span class="material-symbols-outlined">delete</span></button>
                    </div>
                </div>
            `).join('');
        }
        
        window.deleteGalleryItem = async function(id) {
            if (!confirm('Удалить фото?')) return;
            const result = await fetchAPI('api/delete_gallery.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            if (result.success) {
                loadGallery();
                loadStats();
                showToast('Фото удалено');
            } else {
                showToast('Ошибка удаления', true);
            }
        };
        
        async function loadReviews() {
            const data = await fetchAPI('api/get_reviews.php');
            const container = document.getElementById('reviewsList');
            if (!data.success || !data.reviews || data.reviews.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding:40px;">Нет отзывов</div>';
                return;
            }
            container.innerHTML = data.reviews.map(review => `
                <div class="review-item">
                    <div class="review-header">
                        <div>
                            <div class="review-author">${review.author}</div>
                            <div class="review-stars">${'⭐'.repeat(review.rating)}${'☆'.repeat(5-review.rating)}</div>
                        </div>
                        <button class="delete-btn" onclick="deleteReview(${review.id})"><span class="material-symbols-outlined">delete</span></button>
                    </div>
                    <div class="review-text">${review.text || ''}</div>
                    <div style="font-size:12px; color:#9E9E9E;">${new Date(review.created_at).toLocaleDateString()}</div>
                </div>
            `).join('');
        }
        
        window.deleteReview = async function(id) {
            if (!confirm('Удалить отзыв?')) return;
            const result = await fetchAPI('api/delete_review.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            if (result.success) {
                loadReviews();
                showToast('Отзыв удалён');
            } else {
                showToast('Ошибка удаления', true);
            }
        };
        
        async function loadFaq() {
            const data = await fetchAPI('api/get_faq.php');
            const container = document.getElementById('faqList');
            if (!data.success || !data.faq || data.faq.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding:40px;">Нет вопросов</div>';
                return;
            }
            container.innerHTML = data.faq.map(item => `
                <div class="faq-item">
                    <div class="faq-header">
                        <strong>${item.question}</strong>
                        <button class="delete-btn" onclick="deleteFaq(${item.id})"><span class="material-symbols-outlined">delete</span></button>
                    </div>
                    <div class="faq-answer-text">${item.answer}</div>
                </div>
            `).join('');
        }
        
        window.deleteFaq = async function(id) {
            if (!confirm('Удалить вопрос?')) return;
            const result = await fetchAPI('api/delete_faq.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            });
            if (result.success) {
                loadFaq();
                showToast('Вопрос удалён');
            } else {
                showToast('Ошибка удаления', true);
            }
        };
        
        function showToast(message, isError = false) {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
                background: ${isError ? '#C62828' : '#1A1A1A'}; color: #fff;
                padding: 12px 24px; border-radius: 40px; font-size: 14px;
                z-index: 1000; animation: fadeInOut 3s ease;
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
        
        document.getElementById('addGalleryForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const result = await fetch('api/upload_image.php', { method: 'POST', body: formData });
            const data = await result.json();
            if (data.success) {
                await loadGallery();
                await loadStats();
                e.target.reset();
                showToast('Фото добавлено');
            } else {
                showToast(data.error || 'Ошибка загрузки', true);
            }
        });
        
        document.getElementById('addReviewForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const result = await fetchAPI('api/add_review.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.fromEntries(formData))
            });
            if (result.success) {
                await loadReviews();
                e.target.reset();
                showToast('Отзыв добавлен');
            } else {
                showToast('Ошибка добавления', true);
            }
        });
        
        document.getElementById('addFaqForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const result = await fetchAPI('api/add_faq.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.fromEntries(formData))
            });
            if (result.success) {
                await loadFaq();
                e.target.reset();
                showToast('Вопрос добавлен');
            } else {
                showToast('Ошибка добавления', true);
            }
        });
        
        // Tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(`tab-${btn.dataset.tab}`).classList.add('active');
                
                if (btn.dataset.tab === 'orders') loadOrders();
                if (btn.dataset.tab === 'gallery') loadGallery();
                if (btn.dataset.tab === 'reviews') loadReviews();
                if (btn.dataset.tab === 'faq') loadFaq();
            });
        });
        
        loadStats();
        loadOrders();
        loadGallery();
        loadReviews();
        loadFaq();
        
        setInterval(() => { loadStats(); loadOrders(); }, 30000);
        
        const style = document.createElement('style');
        style.textContent = `@keyframes fadeInOut { 0% { opacity: 0; transform: translateX(-50%) translateY(20px); } 15% { opacity: 1; transform: translateX(-50%) translateY(0); } 85% { opacity: 1; } 100% { opacity: 0; } }`;
        document.head.appendChild(style);
    </script>
</body>
</html>
