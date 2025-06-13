import type { Locator, Page } from "@playwright/test";
import { expect } from "@playwright/test";
import { fillText, setPosition, testEntity, testTitle } from "./common";

type GeneratedAisle = {
	name: string;
	storeName: string;
	position: number;
};

/**
 * Edit an aisle.
 *
 * @param _page The Playwright page.
 * @param generate The generated aisle.
 * @param locator The locator.
 * @returns The updated aisle.
 */
async function editAisle(
	_page: Page,
	generate: GeneratedAisle,
	locator: Locator,
) {
	const { storeName } = generate;

	await expect(locator).toBeVisible();
	const randomName2 = await fillText(locator, "Aisle");
	const position2 = await setPosition(locator);
	return { name: randomName2, position: position2, storeName };
}

/**
 * Create an aisle.
 *
 * @param page The Playwright page.
 * @param storeName The store name to create the aisle for.
 * @returns The generated aisle.
 */
async function createAisle(
	page: Page,
	storeName: string,
): Promise<GeneratedAisle> {
	const name = await fillText(page, "Aisle");
	const position = await setPosition(page);
	await page.getByLabel("Store").selectOption({ label: storeName });
	return { name, position, storeName };
}

/**
 * Check the aisle was created.
 *
 * @param page The Playwright page.
 * @param result The generated aisle.
 */
async function checkResult(page: Page, result: GeneratedAisle) {
	const { name, storeName } = result;
	await testTitle(page, "aisle", name);
	await expect(page.getByTestId(`aisle-${name}-store`)).toBeVisible();
	expect(
		await page.getByTestId(`aisle-${name}-store`).textContent(),
	).toContain(storeName);
}

/**
 * Test the aisle creation, editing, and deletion.
 *
 * @param page The Playwright page.
 * @param storeName The store name to create the aisle for.
 * @returns The generated aisle.
 */
export async function testAisle(
	page: Page,
	storeName: string,
): Promise<GeneratedAisle> {
	return await testEntity(
		page,
		"Aisles",
		"aisle",
		(_page) => createAisle(page, storeName),
		checkResult,
		editAisle,
	);
}
