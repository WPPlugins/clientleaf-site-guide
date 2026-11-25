(function () {
	'use strict';

	const rowsContainer = document.querySelector('[data-clientleaf-site-guide-link-rows]');
	const addButton = document.querySelector('[data-clientleaf-site-guide-add-link]');
	const template = document.querySelector('#clientleaf-site-guide-link-row-template');

	if (!rowsContainer || !addButton || !template) {
		return;
	}

	function rows() {
		return Array.from(rowsContainer.querySelectorAll('[data-clientleaf-site-guide-link-row]'));
	}

	function reindexRows() {
		rows().forEach(function (row, index, allRows) {
			row.querySelectorAll('[name]').forEach(function (field) {
				field.name = field.name.replace(/vexmedia_clientleaf_site_guide_quick_links\[[^\]]+\]/, 'vexmedia_clientleaf_site_guide_quick_links[' + index + ']');
			});

			row.querySelectorAll('[id]').forEach(function (field) {
				field.id = field.id.replace(/clientleaf-site-guide-link-[^-]+-/, 'clientleaf-site-guide-link-' + index + '-');
			});

			row.querySelectorAll('label[for]').forEach(function (label) {
				label.htmlFor = label.htmlFor.replace(/clientleaf-site-guide-link-[^-]+-/, 'clientleaf-site-guide-link-' + index + '-');
			});

			const order = row.querySelector('[data-clientleaf-site-guide-order]');
			if (order) {
				order.value = String(index);
			}

			const title = row.querySelector('.clientleaf-site-guide-link-row__title');
			if (title) {
				title.textContent = title.dataset.title + ' ' + (index + 1);
			}

			const up = row.querySelector('[data-clientleaf-site-guide-move="up"]');
			const down = row.querySelector('[data-clientleaf-site-guide-move="down"]');
			if (up) {
				up.disabled = index === 0;
			}
			if (down) {
				down.disabled = index === allRows.length - 1;
			}
			row.querySelectorAll('button').forEach(function (button) {
				if (!button.dataset.actionLabel) {
					button.dataset.actionLabel = button.textContent.trim();
				}
				button.setAttribute('aria-label', button.dataset.actionLabel + ' — ' + title.textContent);
			});
		});
	}

	addButton.addEventListener('click', function () {
		const index = rows().length;
		const html = template.innerHTML.replaceAll('__INDEX__', String(index));
		rowsContainer.insertAdjacentHTML('beforeend', html);
		reindexRows();
		const newRow = rowsContainer.lastElementChild;
		const label = newRow ? newRow.querySelector('[data-field="label"]') : null;
		if (label) {
			label.focus();
		}
	});

	rowsContainer.addEventListener('click', function (event) {
		const button = event.target.closest('button');
		if (!button) {
			return;
		}

		const row = button.closest('[data-clientleaf-site-guide-link-row]');
		if (!row) {
			return;
		}

		if (button.matches('[data-clientleaf-site-guide-remove]')) {
			if (rows().length === 1) {
				row.querySelectorAll('input, textarea').forEach(function (field) {
					field.value = '';
				});
				const label = row.querySelector('[data-field="label"]');
				if (label) {
					label.focus();
				}
			} else {
				const nextFocus = row.previousElementSibling || row.nextElementSibling;
				row.remove();
				reindexRows();
				if (nextFocus) {
					const focusTarget = nextFocus.querySelector('[data-clientleaf-site-guide-remove]');
					if (focusTarget) {
						focusTarget.focus();
					}
				}
			}
			return;
		}

		const direction = button.getAttribute('data-clientleaf-site-guide-move');
		if (direction === 'up' && row.previousElementSibling) {
			rowsContainer.insertBefore(row, row.previousElementSibling);
			button.focus();
		} else if (direction === 'down' && row.nextElementSibling) {
			rowsContainer.insertBefore(row.nextElementSibling, row);
			button.focus();
		}

		reindexRows();
		if (button.disabled) {
			row.querySelector('[data-field="label"]').focus();
		}
	});

	reindexRows();
}());
