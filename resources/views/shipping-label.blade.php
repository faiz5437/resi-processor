<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAKAT KU NYAAH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #111118;
            --bg-tertiary: #1a1a24;
            --bg-glass: rgba(26, 26, 36, 0.7);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #ffffff;
            --text-secondary: #a1a1aa;
            --text-muted: #71717a;
            --accent-primary: #6366f1;
            --accent-secondary: #8b5cf6;
            --accent-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            --success-color: #22c55e;
            --error-color: #ef4444;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-primary); color: var(--text-primary); min-height: 100vh; }
        .bg-gradient { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; background: radial-gradient(ellipse at 30% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 50%), radial-gradient(ellipse at 70% 80%, rgba(139, 92, 246, 0.12) 0%, transparent 50%); }
        .container { max-width: 1400px; margin: 0 auto; padding: 2rem; }
        .header { text-align: center; margin-bottom: 2rem; }
        .header h1 { font-size: 2.5rem; font-weight: 800; background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .header p { color: var(--text-secondary); margin-top: 0.5rem; }
        .glass-card { background: var(--bg-glass); backdrop-filter: blur(20px); border: 1px solid var(--border-color); border-radius: 24px; padding: 2rem; margin-bottom: 2rem; }
        .upload-zone { border: 2px dashed var(--border-color); border-radius: 20px; padding: 3rem 2rem; text-align: center; cursor: pointer; transition: all 0.3s ease; }
        .upload-zone:hover, .upload-zone.dragover { border-color: var(--accent-primary); background: rgba(99, 102, 241, 0.05); }
        .upload-icon { width: 70px; height: 70px; margin: 0 auto 1rem; background: var(--accent-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .upload-icon svg { color: white; width: 32px; height: 32px; }
        .upload-btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.75rem; background: var(--accent-gradient); color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; margin-top: 1rem; }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .section-title { display: flex; align-items: center; gap: 0.75rem; font-size: 1.25rem; font-weight: 600; }
        .badge { padding: 0.375rem 0.875rem; background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 999px; font-size: 0.85rem; color: var(--success-color); }
        .preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; }
        .preview-item { position: relative; aspect-ratio: 3/4; background: var(--bg-tertiary); border-radius: 16px; overflow: hidden; border: 1px solid var(--border-color); cursor: pointer; transition: all 0.3s ease; }
        .preview-item:hover { transform: translateY(-4px); border-color: var(--accent-primary); box-shadow: 0 12px 30px rgba(99, 102, 241, 0.2); }
        .preview-item img { width: 100%; height: 100%; object-fit: contain; padding: 0.5rem; }
        .preview-item .edit-overlay { position: absolute; inset: 0; background: rgba(99, 102, 241, 0.8); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s; }
        .preview-item:hover .edit-overlay { opacity: 1; }
        .preview-item .edit-overlay span { color: white; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; }
        .preview-item .remove-btn { position: absolute; top: 0.5rem; right: 0.5rem; width: 28px; height: 28px; background: rgba(239, 68, 68, 0.9); border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; z-index: 10; opacity: 0; transition: opacity 0.3s; }
        .preview-item:hover .remove-btn { opacity: 1; }
        .preview-item .item-number { position: absolute; bottom: 0.5rem; left: 0.5rem; width: 24px; height: 24px; background: var(--accent-gradient); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600; }
        .empty-state { text-align: center; padding: 3rem; color: var(--text-muted); }
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-item { background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 14px; padding: 1rem; text-align: center; }
        .stat-item .value { font-size: 1.75rem; font-weight: 700; background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-item .label { font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.25rem; }
        .settings-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .setting-item { background: var(--bg-tertiary); border: 1px solid var(--border-color); border-radius: 14px; padding: 1rem; }
        .setting-item label { display: block; font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.5rem; }
        .setting-item select, .setting-item input[type="number"] { width: 100%; padding: 0.75rem; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 1rem; }
        .setting-item select:focus, .setting-item input:focus { outline: none; border-color: var(--accent-primary); }
        .actions { display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; font-size: 1rem; font-weight: 600; border: none; border-radius: 14px; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: var(--accent-gradient); color: white; box-shadow: 0 8px 30px rgba(99, 102, 241, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-secondary { background: var(--bg-tertiary); color: var(--text-primary); border: 1px solid var(--border-color); }
        .modal-overlay { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; z-index: 1000; padding: 1rem; }
        .modal-overlay.active { display: flex; }
        .modal-content { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 24px; padding: 2rem; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .modal-header h3 { font-size: 1.25rem; font-weight: 600; }
        .modal-close { width: 36px; height: 36px; background: var(--bg-tertiary); border: none; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-primary); }
        .crop-preview-container { position: relative; background: var(--bg-tertiary); border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem; cursor: crosshair; }
        .crop-preview-container img { width: 100%; display: block; }
        .crop-frame { position: absolute; border: 2px solid #6366f1; background: transparent; cursor: move; box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6); }
        .crop-frame::before { content: ''; position: absolute; inset: 0; border: 1px dashed rgba(255,255,255,0.3); pointer-events: none; }
        .resize-handle { position: absolute; width: 14px; height: 14px; background: #6366f1; border: 2px solid white; border-radius: 50%; z-index: 10; }
        .resize-handle.nw { top: -7px; left: -7px; cursor: nw-resize; }
        .resize-handle.n { top: -7px; left: 50%; transform: translateX(-50%); cursor: n-resize; }
        .resize-handle.ne { top: -7px; right: -7px; cursor: ne-resize; }
        .resize-handle.w { top: 50%; left: -7px; transform: translateY(-50%); cursor: w-resize; }
        .resize-handle.e { top: 50%; right: -7px; transform: translateY(-50%); cursor: e-resize; }
        .resize-handle.sw { bottom: -7px; left: -7px; cursor: sw-resize; }
        .resize-handle.s { bottom: -7px; left: 50%; transform: translateX(-50%); cursor: s-resize; }
        .resize-handle.se { bottom: -7px; right: -7px; cursor: se-resize; }
        .crop-info { display: flex; align-items: center; justify-content: center; gap: 1rem; padding: 1rem; background: var(--bg-tertiary); border-radius: 12px; margin-bottom: 1rem; }
        .crop-info-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-secondary); }
        .crop-info-item span { color: var(--accent-primary); font-weight: 600; }
        .crop-hint { text-align: center; padding: 0.75rem; color: var(--text-muted); font-size: 0.85rem; background: var(--bg-tertiary); border-radius: 12px; }
        .modal-actions { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .modal-actions .btn { flex: 1; justify-content: center; }
        .loader-modal .modal-content { text-align: center; max-width: 350px; }
        .loader { width: 60px; height: 60px; margin: 0 auto 1rem; border: 4px solid var(--bg-tertiary); border-top-color: var(--accent-primary); border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .progress-bar { height: 6px; background: var(--bg-tertiary); border-radius: 3px; margin-top: 1rem; overflow: hidden; }
        .progress-fill { height: 100%; background: var(--accent-gradient); width: 0%; transition: width 0.3s; }
        .toast-container { position: fixed; bottom: 2rem; right: 2rem; z-index: 1001; display: flex; flex-direction: column; gap: 0.5rem; }
        .toast { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 12px; padding: 1rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
        #fileInput { display: none; }
        @media (max-width: 768px) { .container { padding: 1rem; } .header h1 { font-size: 1.75rem; } .glass-card { padding: 1.25rem; } .preview-grid { grid-template-columns: repeat(2, 1fr); } .actions { flex-direction: column; } .btn { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    <div class="container">
        <header class="header">
            <h1>💖 BAKAT KU NYAAH</h1>
            <p>Upload, crop, dan convert label pengiriman ke PDF</p>
        </header>

        <section class="glass-card">
            <div class="upload-zone" id="uploadZone">
                <div class="upload-icon"><i data-lucide="upload-cloud"></i></div>
                <h3>Upload Label Pengiriman</h3>
                <p style="color: var(--text-secondary)">Drag & drop atau klik untuk memilih</p>
                <button class="upload-btn"><i data-lucide="folder-open" width="18" height="18"></i> Pilih Gambar</button>
            </div>
            <input type="file" id="fileInput" accept="image/*" multiple>
        </section>

        <div class="stats-row">
            <div class="stat-item"><div class="value" id="totalImages">0</div><div class="label">Total Gambar</div></div>
            <div class="stat-item"><div class="value" id="totalPages">0</div><div class="label">Halaman PDF</div></div>
            <div class="stat-item"><div class="value" id="gridDisplay">2×3</div><div class="label">Grid Layout</div></div>
            <div class="stat-item"><div class="value" id="perPage">6</div><div class="label">Per Halaman</div></div>
        </div>

        <section class="glass-card" id="settingsSection">
            <div class="section-header">
                <div class="section-title"><i data-lucide="sliders" width="20" height="20"></i> Pengaturan Layout</div>
            </div>
            <div class="settings-grid">
                <div class="setting-item">
                    <label>Kolom</label>
                    <select id="gridCols">
                        <option value="1">1 Kolom</option>
                        <option value="2" selected>2 Kolom</option>
                        <option value="3">3 Kolom</option>
                        <option value="4">4 Kolom</option>
                    </select>
                </div>
                <div class="setting-item">
                    <label>Baris</label>
                    <select id="gridRows">
                        <option value="1">1 Baris</option>
                        <option value="2">2 Baris</option>
                        <option value="3" selected>3 Baris</option>
                        <option value="4">4 Baris</option>
                        <option value="5">5 Baris</option>
                    </select>
                </div>
                <div class="setting-item">
                    <label>Margin (mm)</label>
                    <input type="number" id="marginSize" value="5" min="0" max="20">
                </div>
                <div class="setting-item">
                    <label>Crop Atas (%)</label>
                    <input type="number" id="defaultCropTop" value="20" min="0" max="50">
                </div>
                <div class="setting-item">
                    <label>Crop Bawah (%)</label>
                    <input type="number" id="defaultCropBottom" value="30" min="0" max="50">
                </div>
                <div class="setting-item">
                    <label>Crop Samping (%)</label>
                    <input type="number" id="defaultCropSide" value="3" min="0" max="20">
                </div>
            </div>
        </section>

        <section class="glass-card" id="previewSection" style="display: none;">
            <div class="section-header">
                <div class="section-title"><i data-lucide="images" width="20" height="20"></i> Preview Gambar</div>
                <span class="badge" id="previewBadge">0 gambar</span>
            </div>
            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem;">💡 Klik gambar untuk edit crop manual</p>
            <div class="preview-grid" id="previewGrid"></div>
        </section>

        <section class="glass-card" id="emptyState">
            <div class="empty-state">
                <i data-lucide="image-off" width="48" height="48" style="margin-bottom: 1rem; opacity: 0.5;"></i>
                <h3>Belum Ada Gambar</h3>
                <p>Upload gambar label untuk memulai</p>
            </div>
        </section>

        <section class="glass-card" id="actionsSection" style="display: none;">
            <div class="actions">
                <button class="btn btn-primary" id="convertBtn"><i data-lucide="file-down" width="20" height="20"></i> Convert to PDF</button>
                <button class="btn btn-secondary" id="clearBtn"><i data-lucide="trash-2" width="20" height="20"></i> Hapus Semua</button>
            </div>
        </section>
    </div>

    <!-- Crop Editor Modal -->
    <div class="modal-overlay" id="cropModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>✂️ Edit Crop</h3>
                <button class="modal-close" id="closeCropModal"><i data-lucide="x" width="20" height="20"></i></button>
            </div>
            <div class="crop-info">
                <div class="crop-info-item">📐 Width: <span id="cropWidthInfo">0px</span></div>
                <div class="crop-info-item">📏 Height: <span id="cropHeightInfo">0px</span></div>
            </div>
            <div class="crop-preview-container" id="cropContainer">
                <img id="cropPreviewImg" src="" alt="Crop Preview" style="user-select: none; pointer-events: none;">
                <div class="crop-frame" id="cropFrame">
                    <div class="resize-handle nw" data-handle="nw"></div>
                    <div class="resize-handle n" data-handle="n"></div>
                    <div class="resize-handle ne" data-handle="ne"></div>
                    <div class="resize-handle w" data-handle="w"></div>
                    <div class="resize-handle e" data-handle="e"></div>
                    <div class="resize-handle sw" data-handle="sw"></div>
                    <div class="resize-handle s" data-handle="s"></div>
                    <div class="resize-handle se" data-handle="se"></div>
                </div>
            </div>
            <div class="crop-hint">💡 Drag frame untuk memindahkan • Drag handle sudut/sisi untuk resize</div>
            <div class="modal-actions">
                <button class="btn btn-secondary" id="resetCrop"><i data-lucide="rotate-ccw" width="18" height="18"></i> Reset</button>
                <button class="btn btn-primary" id="applyCrop"><i data-lucide="check" width="18" height="18"></i> Terapkan</button>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal-overlay loader-modal" id="loadingModal">
        <div class="modal-content">
            <div class="loader"></div>
            <h3>Memproses PDF</h3>
            <p id="loadingText" style="color: var(--text-secondary);">Mengkonversi gambar...</p>
            <div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        lucide.createIcons();
        
        const $ = id => document.getElementById(id);
        const uploadZone = $('uploadZone'), fileInput = $('fileInput'), previewGrid = $('previewGrid');
        const previewSection = $('previewSection'), actionsSection = $('actionsSection'), emptyState = $('emptyState');
        const cropModal = $('cropModal');
        const cropContainer = $('cropContainer');
        const cropFrame = $('cropFrame');
        const cropPreviewImg = $('cropPreviewImg');
        const loadingModal = $('loadingModal'), progressFill = $('progressFill'), loadingText = $('loadingText');
        
        let images = []; // {original: Image, cropRect: {x, y, w, h}, cropped: dataUrl}
        let currentEditIndex = -1;
        let currentOriginalImage = null;
        
        // Crop frame state
        let containerRect = null;
        let imageDisplaySize = { w: 0, h: 0 };
        let isDragging = false;
        let isResizing = false;
        let currentHandle = null;
        let dragStart = { x: 0, y: 0 };
        let frameStart = { x: 0, y: 0, w: 0, h: 0 };

        // Grid settings
        const gridCols = $('gridCols'), gridRows = $('gridRows'), marginSize = $('marginSize');
        const defaultCropTop = $('defaultCropTop'), defaultCropBottom = $('defaultCropBottom'), defaultCropSide = $('defaultCropSide');
        
        function getGridSettings() {
            return { cols: parseInt(gridCols.value), rows: parseInt(gridRows.value), margin: parseInt(marginSize.value) };
        }
        
        function getDefaultCrop() {
            return { top: parseInt(defaultCropTop.value), bottom: parseInt(defaultCropBottom.value), side: parseInt(defaultCropSide.value) };
        }

        // Update grid display
        [gridCols, gridRows].forEach(el => el.addEventListener('change', () => {
            const g = getGridSettings();
            $('gridDisplay').textContent = `${g.cols}×${g.rows}`;
            $('perPage').textContent = g.cols * g.rows;
            updateStats();
        }));

        // Upload handlers
        uploadZone.addEventListener('click', () => fileInput.click());
        uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
        uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
        uploadZone.addEventListener('drop', e => { e.preventDefault(); uploadZone.classList.remove('dragover'); handleFiles(e.dataTransfer.files); });
        fileInput.addEventListener('change', e => { handleFiles(e.target.files); fileInput.value = ''; });

        async function handleFiles(files) {
            const imageFiles = Array.from(files).filter(f => f.type.startsWith('image/'));
            if (!imageFiles.length) return showToast('Pilih file gambar', 'error');
            
            showToast(`Memproses ${imageFiles.length} gambar...`);
            const defCrop = getDefaultCrop();
            
            for (const file of imageFiles) {
                const img = await loadImage(file);
                // Convert default crop percentages to cropRect
                const cropRect = {
                    x: defCrop.side / 100,
                    y: defCrop.top / 100,
                    w: 1 - (2 * defCrop.side / 100),
                    h: 1 - (defCrop.top / 100) - (defCrop.bottom / 100)
                };
                const cropped = applyCropToImage(img, cropRect);
                images.push({ original: img, cropRect, cropped });
            }
            updateUI();
        }

        function loadImage(file) {
            return new Promise(resolve => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = new Image();
                    img.onload = () => resolve(img);
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        function applyCropToImage(img, cropRect) {
            const canvas = document.createElement('canvas');
            const c = canvas.getContext('2d');
            const sX = img.width * cropRect.x;
            const sY = img.height * cropRect.y;
            const sWidth = img.width * cropRect.w;
            const sHeight = img.height * cropRect.h;
            canvas.width = sWidth; canvas.height = sHeight;
            c.drawImage(img, sX, sY, sWidth, sHeight, 0, 0, sWidth, sHeight);
            return canvas.toDataURL('image/jpeg', 0.92);
        }

        function updateStats() {
            const g = getGridSettings();
            $('totalImages').textContent = images.length;
            $('totalPages').textContent = Math.ceil(images.length / (g.cols * g.rows));
        }

        function updateUI() {
            updateStats();
            $('previewBadge').textContent = `${images.length} gambar`;
            
            if (images.length > 0) {
                emptyState.style.display = 'none';
                previewSection.style.display = 'block';
                actionsSection.style.display = 'block';
                renderPreviews();
            } else {
                emptyState.style.display = 'block';
                previewSection.style.display = 'none';
                actionsSection.style.display = 'none';
            }
            lucide.createIcons();
        }

        function renderPreviews() {
            previewGrid.innerHTML = images.map((item, i) => `
                <div class="preview-item" onclick="openCropEditor(${i})">
                    <img src="${item.cropped}" alt="Preview ${i + 1}">
                    <div class="edit-overlay"><span><i data-lucide="crop" width="20" height="20"></i> Edit Crop</span></div>
                    <button class="remove-btn" onclick="event.stopPropagation(); removeImage(${i})"><i data-lucide="x" width="14" height="14"></i></button>
                    <span class="item-number">${i + 1}</span>
                </div>
            `).join('');
            lucide.createIcons();
        }

        function removeImage(index) {
            images.splice(index, 1);
            updateUI();
            showToast('Gambar dihapus');
        }

        // =============== CROP FRAME EDITOR ===============
        function openCropEditor(index) {
            currentEditIndex = index;
            currentOriginalImage = images[index].original;
            const cropRect = images[index].cropRect;
            
            // Set image source
            cropPreviewImg.src = currentOriginalImage.src;
            cropPreviewImg.onload = () => {
                // Wait a frame for layout
                requestAnimationFrame(() => {
                    initCropFrame(cropRect);
                });
            };
            
            cropModal.classList.add('active');
            lucide.createIcons();
        }
        
        function initCropFrame(cropRect) {
            containerRect = cropContainer.getBoundingClientRect();
            const imgRect = cropPreviewImg.getBoundingClientRect();
            
            // Calculate actual image display size (considering object-fit)
            const imgNaturalW = currentOriginalImage.width;
            const imgNaturalH = currentOriginalImage.height;
            const containerW = cropContainer.clientWidth;
            const containerH = cropContainer.clientHeight || 400;
            
            // Image scales to fit container width
            imageDisplaySize.w = containerW;
            imageDisplaySize.h = (imgNaturalH / imgNaturalW) * containerW;
            
            // Set frame position based on cropRect (normalized 0-1)
            const frameX = cropRect.x * imageDisplaySize.w;
            const frameY = cropRect.y * imageDisplaySize.h;
            const frameW = cropRect.w * imageDisplaySize.w;
            const frameH = cropRect.h * imageDisplaySize.h;
            
            cropFrame.style.left = `${frameX}px`;
            cropFrame.style.top = `${frameY}px`;
            cropFrame.style.width = `${frameW}px`;
            cropFrame.style.height = `${frameH}px`;
            
            updateCropInfo();
        }
        
        function updateCropInfo() {
            const frameW = parseFloat(cropFrame.style.width) || 0;
            const frameH = parseFloat(cropFrame.style.height) || 0;
            
            // Calculate actual crop size in original image pixels
            const scaleX = currentOriginalImage.width / imageDisplaySize.w;
            const scaleY = currentOriginalImage.height / imageDisplaySize.h;
            
            const actualW = Math.round(frameW * scaleX);
            const actualH = Math.round(frameH * scaleY);
            
            $('cropWidthInfo').textContent = `${actualW}px`;
            $('cropHeightInfo').textContent = `${actualH}px`;
        }
        
        function getFrameRect() {
            return {
                x: parseFloat(cropFrame.style.left) || 0,
                y: parseFloat(cropFrame.style.top) || 0,
                w: parseFloat(cropFrame.style.width) || 100,
                h: parseFloat(cropFrame.style.height) || 100
            };
        }
        
        function setFrameRect(x, y, w, h) {
            // Constrain to image bounds
            const minSize = 20;
            w = Math.max(minSize, Math.min(w, imageDisplaySize.w));
            h = Math.max(minSize, Math.min(h, imageDisplaySize.h));
            x = Math.max(0, Math.min(x, imageDisplaySize.w - w));
            y = Math.max(0, Math.min(y, imageDisplaySize.h - h));
            
            cropFrame.style.left = `${x}px`;
            cropFrame.style.top = `${y}px`;
            cropFrame.style.width = `${w}px`;
            cropFrame.style.height = `${h}px`;
            
            updateCropInfo();
        }
        
        function getMousePos(e) {
            const rect = cropContainer.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }
        
        // Mouse/Touch event handlers for frame dragging
        cropFrame.addEventListener('mousedown', startDrag);
        cropFrame.addEventListener('touchstart', startDrag, { passive: false });
        
        function startDrag(e) {
            if (e.target.classList.contains('resize-handle')) {
                // Handle resize
                isResizing = true;
                currentHandle = e.target.dataset.handle;
            } else {
                // Handle move
                isDragging = true;
            }
            
            e.preventDefault();
            dragStart = getMousePos(e);
            const rect = getFrameRect();
            frameStart = { x: rect.x, y: rect.y, w: rect.w, h: rect.h };
            
            document.addEventListener('mousemove', onDrag);
            document.addEventListener('mouseup', stopDrag);
            document.addEventListener('touchmove', onDrag, { passive: false });
            document.addEventListener('touchend', stopDrag);
        }
        
        function onDrag(e) {
            e.preventDefault();
            const pos = getMousePos(e);
            const dx = pos.x - dragStart.x;
            const dy = pos.y - dragStart.y;
            
            if (isDragging) {
                // Move the frame
                setFrameRect(frameStart.x + dx, frameStart.y + dy, frameStart.w, frameStart.h);
            } else if (isResizing) {
                // Resize based on handle
                let newX = frameStart.x;
                let newY = frameStart.y;
                let newW = frameStart.w;
                let newH = frameStart.h;
                
                switch (currentHandle) {
                    case 'nw':
                        newX = frameStart.x + dx;
                        newY = frameStart.y + dy;
                        newW = frameStart.w - dx;
                        newH = frameStart.h - dy;
                        break;
                    case 'n':
                        newY = frameStart.y + dy;
                        newH = frameStart.h - dy;
                        break;
                    case 'ne':
                        newY = frameStart.y + dy;
                        newW = frameStart.w + dx;
                        newH = frameStart.h - dy;
                        break;
                    case 'w':
                        newX = frameStart.x + dx;
                        newW = frameStart.w - dx;
                        break;
                    case 'e':
                        newW = frameStart.w + dx;
                        break;
                    case 'sw':
                        newX = frameStart.x + dx;
                        newW = frameStart.w - dx;
                        newH = frameStart.h + dy;
                        break;
                    case 's':
                        newH = frameStart.h + dy;
                        break;
                    case 'se':
                        newW = frameStart.w + dx;
                        newH = frameStart.h + dy;
                        break;
                }
                
                // Handle negative width/height
                if (newW < 20) {
                    if (currentHandle.includes('w')) newX = frameStart.x + frameStart.w - 20;
                    newW = 20;
                }
                if (newH < 20) {
                    if (currentHandle.includes('n')) newY = frameStart.y + frameStart.h - 20;
                    newH = 20;
                }
                
                setFrameRect(newX, newY, newW, newH);
            }
        }
        
        function stopDrag() {
            isDragging = false;
            isResizing = false;
            currentHandle = null;
            
            document.removeEventListener('mousemove', onDrag);
            document.removeEventListener('mouseup', stopDrag);
            document.removeEventListener('touchmove', onDrag);
            document.removeEventListener('touchend', stopDrag);
        }

        $('closeCropModal').addEventListener('click', () => cropModal.classList.remove('active'));
        
        $('resetCrop').addEventListener('click', () => {
            const def = getDefaultCrop();
            const cropRect = {
                x: def.side / 100,
                y: def.top / 100,
                w: 1 - (2 * def.side / 100),
                h: 1 - (def.top / 100) - (def.bottom / 100)
            };
            initCropFrame(cropRect);
        });

        $('applyCrop').addEventListener('click', () => {
            const rect = getFrameRect();
            
            // Convert frame position to normalized cropRect (0-1)
            const cropRect = {
                x: rect.x / imageDisplaySize.w,
                y: rect.y / imageDisplaySize.h,
                w: rect.w / imageDisplaySize.w,
                h: rect.h / imageDisplaySize.h
            };
            
            images[currentEditIndex].cropRect = cropRect;
            images[currentEditIndex].cropped = applyCropToImage(currentOriginalImage, cropRect);
            cropModal.classList.remove('active');
            renderPreviews();
            showToast('Crop diterapkan!');
        });

        // Clear all
        $('clearBtn').addEventListener('click', () => {
            if (!images.length) return;
            images = [];
            updateUI();
            showToast('Semua gambar dihapus');
        });

        // Convert to PDF
        $('convertBtn').addEventListener('click', async () => {
            if (!images.length) return showToast('Tidak ada gambar', 'error');
            
            loadingModal.classList.add('active');
            progressFill.style.width = '0%';
            
            try {
                await generatePDF();
                showToast('PDF berhasil dibuat!');
            } catch (e) {
                console.error(e);
                showToast('Gagal membuat PDF', 'error');
            } finally {
                loadingModal.classList.remove('active');
            }
        });

        async function generatePDF() {
            const { jsPDF } = window.jspdf;
            const g = getGridSettings();
            const pageW = 210, pageH = 297, margin = g.margin;
            const cols = g.cols, rows = g.rows, perPage = cols * rows;
            
            const cellW = (pageW - margin * 2 - (cols - 1) * margin) / cols;
            const cellH = (pageH - margin * 2 - (rows - 1) * margin) / rows;
            
            const pdf = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
            const totalPages = Math.ceil(images.length / perPage);
            
            for (let page = 0; page < totalPages; page++) {
                if (page > 0) pdf.addPage();
                const start = page * perPage;
                const end = Math.min(start + perPage, images.length);
                
                for (let i = start; i < end; i++) {
                    const pos = i - start;
                    const col = pos % cols;
                    const row = Math.floor(pos / cols);
                    const x = margin + col * (cellW + margin);
                    const y = margin + row * (cellH + margin);
                    
                    const imgData = images[i].cropped;
                    const dim = await getImageDimensions(imgData);
                    const imgAspect = dim.width / dim.height;
                    const cellAspect = cellW / cellH;
                    
                    let drawW, drawH, drawX, drawY;
                    if (imgAspect > cellAspect) {
                        drawW = cellW; drawH = cellW / imgAspect;
                        drawX = x; drawY = y + (cellH - drawH) / 2;
                    } else {
                        drawH = cellH; drawW = cellH * imgAspect;
                        drawX = x + (cellW - drawW) / 2; drawY = y;
                    }
                    
                    pdf.addImage(imgData, 'JPEG', drawX, drawY, drawW, drawH);
                    
                    progressFill.style.width = `${((i + 1) / images.length) * 100}%`;
                    loadingText.textContent = `Gambar ${i + 1} dari ${images.length}...`;
                    await new Promise(r => setTimeout(r, 30));
                }
            }
            
            const date = new Date().toISOString().slice(0, 10);
            pdf.save(`shipping-labels-${date}.pdf`);
        }

        function getImageDimensions(dataUrl) {
            return new Promise(resolve => {
                const img = new Image();
                img.onload = () => resolve({ width: img.width, height: img.height });
                img.src = dataUrl;
            });
        }

        function showToast(msg, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `<i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" width="18" height="18" style="color: ${type === 'success' ? 'var(--success-color)' : 'var(--error-color)'}"></i><span>${msg}</span>`;
            $('toastContainer').appendChild(toast);
            lucide.createIcons();
            setTimeout(() => toast.remove(), 3000);
        }

        updateUI();
    </script>
</body>
</html>
