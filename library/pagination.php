<?php
// library/pagination.php - library pagination (fungsi terstruktur)

/**
 * Render pagination link.
 * - $page: halaman aktif (int)
 * - $perPage: item per halaman (int)
 * - $total: total item (int)
 * - $baseUrl: file target, mis. "artikel_list.php"
 */
function renderPagination($page, $perPage, $total, $baseUrl) {
    $totalPages = (int) ceil($total / $perPage);
    if ($totalPages <= 1) return "";

    // batasi page supaya aman
    if ($page < 1) $page = 1;
    if ($page > $totalPages) $page = $totalPages;

    $html = "<nav class='pagination' aria-label='Pagination'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = ($i === (int)$page) ? "active" : "";
        $html .= "<a class='page $active' href='{$baseUrl}?page={$i}'>{$i}</a>";
    }
    $html .= "</nav>";
    return $html;
}
