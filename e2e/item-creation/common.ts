import { expect, Locator, Page } from "@playwright/test";

/**
 * Test the delete functionality
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param generatedTitle The generated title for the entity.
 */
export async function testDelete(
    page: Page,
    prefix: string,
    generatedTitle: string,
) {
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
 * @param page The Playwright page to test with.
 */
export async function save(page: Page | Locator) {
    await expect(page.getByTestId("save")).toBeVisible();
    await page.getByTestId("save").click();
}

/**
 * Randomly sets the position of the entity.
 * @param page The Playwright page to test with.
 * @returns The position of the entity.
 */
export async function setPosition(page: Page | Locator) {
    const position = Math.floor(Math.random() * 99);
    await page.getByLabel("Position").fill(position.toString());
    return position;
}

/**
 * Tests that the title is visible in the item list and contains the generated title.
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param generateTitle The generated title for the entity.
 */
export async function testTitle(
    page: Page | Locator,
    prefix: string,
    generateTitle: string,
) {
    await expect(
        page.getByTestId(`${prefix}-${generateTitle}-title`),
    ).toBeVisible();
    expect(
        await page
            .getByTestId(`${prefix}-${generateTitle}-title`)
            .textContent(),
    ).toContain(generateTitle);
}

/**
 * Opens the edit dialog for the entity.
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param generatedName The generated title for the entity.
 */
export async function openEdit(
    page: Page,
    prefix: string,
    generatedName: string,
) {
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
 * @param page The Playwright page to test with.
 * @param prefix The prefix for the entity type (ex. aisle).
 * @param fieldLabel The label for the field to fill. Defaults to "Description".
 */
export async function fillText(
    page: Page | Locator,
    prefix: string,
    fieldLabel: string = "Description",
) {
    await expect(page.getByLabel(fieldLabel)).toBeVisible();
    const randomName = `${prefix} ${Math.floor(Math.random() * 1000)}`;
    await page.getByLabel(fieldLabel).fill(randomName);
    return randomName;
}

export async function testEntity<T extends { name: string }>(
    page: Page,
    navLabel: string,
    prefix: string,
    create: (page: Page) => Promise<T>,
    check: (page: Page, entity: T) => Promise<void>,
    edit: (page: Page, entity: T, locator: Locator) => Promise<T>,
    first = true,
): Promise<T> {
    await page.getByText(navLabel).first().click();

    const l = await create(page);
    await save(page);
    await check(page, l);
    if (first) {
        await openEdit(page, prefix, l.name);
        const locator = page.locator(`[data-testid=${prefix}-${l.name}-title]`);
        const l2 = await edit(page, l, locator);
        await save(locator);
        await expect(
            page.getByTestId(`${prefix}-${l.name}-title`),
        ).not.toBeVisible();
        await check(page, l2);
        await testDelete(page, prefix, l2.name);
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
