import { expect, Page } from "@playwright/test";
import {
    fillText,
    openEdit,
    setPosition,
    testEntity,
    testTitle,
} from "./common";

type GeneratedAisle = {
    name: string;
    storeName: string;
    position: number;
};

async function editAisle(
    page: Page,
    generate: GeneratedAisle,
): Promise<GeneratedAisle> {
    const { name: randomName, storeName } = generate;
    await openEdit(page, "aisle", randomName);
    await page.waitForTimeout(1000);
    const titleContainer = page
        .getByTestId(`aisle-${randomName}-title`)
        .first();
    await expect(titleContainer).toBeVisible();
    const randomName2 = await fillText(titleContainer, "Aisle");
    const position2 = await setPosition(titleContainer);
    return { name: randomName2, position: position2, storeName };
}

async function createAisle(
    page: Page,
    storeName: string,
): Promise<GeneratedAisle> {
    const name = await fillText(page, "Aisle");
    const position = await setPosition(page);
    await page.getByLabel("Store").selectOption({ label: storeName });
    return { name, position, storeName };
}

async function checkResult(page: Page, result: GeneratedAisle) {
    const { name, storeName } = result;
    await testTitle(page, "aisle", name);
    await expect(page.getByTestId(`aisle-${name}-store`)).toBeVisible();
    expect(
        await page.getByTestId(`aisle-${name}-store`).textContent(),
    ).toContain(storeName);
}

export async function testAisle(page: Page, storeName: string) {
    return await testEntity(
        page,
        "Aisles",
        "aisle",
        (page) => createAisle(page, storeName),
        checkResult,
        editAisle,
    );
}
