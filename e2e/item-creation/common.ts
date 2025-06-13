import type { Locator, Page } from "@playwright/test";
import { expect } from "@playwright/test";

/**
 * Test the delete functionality
 *
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param generatedTitle The generated title for the entity.
 */
export async function testDelete(
	page: Page,
	prefix: string,
	generatedTitle: string,
): Promise<void> {
	await page.getByTestId(`${prefix}-${generatedTitle}-tools-toggle`).click();
	await expect(
		page.getByTestId(`${prefix}-${generatedTitle}-delete`),
	).toBeVisible();
	await page.getByTestId(`${prefix}-${generatedTitle}-delete`).click();
	await expect(
		page.getByTestId(`${prefix}-${generatedTitle}-title`),
	).not.toBeVisible();
}

/**
 * Saves the entity after creating.
 *
 * @param page The Playwright page to test with.
 */
export async function save(page: Page | Locator): Promise<void> {
	await expect(page.getByTestId("save")).toBeVisible();
	await page.getByTestId("save").click();
}

/**
 * Randomly sets the position of the entity.
 *
 * @param page The Playwright page to test with.
 * @returns The position of the entity.
 */
export async function setPosition(page: Page | Locator): Promise<number> {
	const position = Math.floor(Math.random() * 99);
	await page.getByLabel("Position").fill(position.toString());
	return position;
}

/**
 * Tests that the title is visible in the item list and contains the generated
 * title.
 *
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param generateTitle The generated title for the entity.
 * @param options Content to check for instead of the generated title.
 * @param options.contentOverride The content to check for instead of the
 *   generated title.
 */
export async function testTitle(
	page: Page | Locator,
	prefix: string,
	generateTitle: string,
	options?: {
		contentOverride?: string;
	},
): Promise<void> {
	await expect(
		page.getByTestId(`${prefix}-${generateTitle}-title`),
	).toBeVisible();
	expect(
		await page
			.getByTestId(`${prefix}-${generateTitle}-title`)
			.textContent(),
	).toContain(options?.contentOverride || generateTitle);
}

/**
 * Opens the edit dialog for the entity.
 *
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param generatedName The generated title for the entity.
 */
export async function openEdit(
	page: Page,
	prefix: string,
	generatedName: string,
): Promise<void> {
	await expect(
		page.getByTestId(`${prefix}-${generatedName}-tools-toggle`),
	).toBeVisible();
	await page.getByTestId(`${prefix}-${generatedName}-tools-toggle`).click();
	await expect(
		page.getByTestId(`${prefix}-${generatedName}-edit`),
	).toBeVisible();
	await page.getByTestId(`${prefix}-${generatedName}-edit`).click();
	await expect(
		page.getByTestId(`${prefix}-${generatedName}-title`).locator("form"),
	).toBeVisible();
}

/**
 * Randomly fills the text field with a generated name.
 *
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param testId The test ID for the text field.
 * @returns The generated name.
 */
export async function fillText(
	page: Page | Locator,
	prefix: string,
	testId: string = "primary-text",
): Promise<string> {
	await expect(page.getByTestId(testId)).toBeVisible();
	const randomName = `${prefix} ${Math.floor(Math.random() * 100000)}`;
	await page.getByTestId(testId).fill(randomName);
	await expect(page.getByTestId(testId)).toHaveValue(randomName);
	return randomName;
}

/**
 * Tests the entity creation, editing, and deletion.
 *
 * @template T The entity type.
 * @param page The Playwright page to test with.
 * @param navLabel The label for the navigation item. (Used to navigate to the
 *   page).
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param create The function to create the entity.
 * @param check The function to verify the entity.
 * @param edit The function to edit the entity.
 * @param first Whether this is the first pass of the test.
 * @param options Additional options.
 * @param options.urlOverride The URL to navigate to instead of the default.
 * @returns The generated entity.
 */
export async function testEntity<
	T extends { name: string; titleOverride?: string },
>(
	page: Page,
	navLabel: string,
	prefix: string,
	create: (page: Page) => Promise<T>,
	check: (page: Page, entity: T) => Promise<void>,
	edit: (page: Page, entity: T, locator: Locator) => Promise<T>,
	first = true,
	options?: {
		urlOverride?: string;
	},
): Promise<T> {
	if (first) {
		await page.getByText(navLabel).first().click();

		await page.waitForURL(
			"**/" + (options?.urlOverride || navLabel.toLowerCase()),
		);
	} else {
		await page.reload();
	}
	const l = await create(page);
	await save(page);
	await check(page, l);
	if (first) {
		await openEdit(page, prefix, l.name);
		const locator = page.getByTestId(`${prefix}-${l.name}-title`);
		await expect(locator).toBeVisible();
		const l2 = await edit(page, l, locator);
		await save(locator);
		await expect(
			page.getByTestId(`${prefix}-${l.name}-title`),
		).not.toBeVisible();
		await check(page, l2);
		await testDelete(page, prefix, l2.name);
		await page.waitForTimeout(1000);
		return await testEntity(
			page,
			navLabel,
			prefix,
			create,
			check,
			edit,
			false,
		);
	}
	return l;
}
