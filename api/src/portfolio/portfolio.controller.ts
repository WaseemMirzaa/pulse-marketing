import { Body, Controller, Delete, Get, Param, Post, Put, UseGuards } from "@nestjs/common";
import { PortfolioService } from "./portfolio.service";
import { CreateCaseDto, UpdateCaseDto } from "./portfolio.dto";
import { AdminKeyGuard } from "../content/admin-key.guard";

@Controller("api/portfolio")
export class PortfolioController {
  constructor(private readonly portfolio: PortfolioService) {}

  @Get()
  list() {
    return this.portfolio.listPublished();
  }

  @Get(":slug")
  getBySlug(@Param("slug") caseSlug: string) {
    return this.portfolio.getBySlug(caseSlug);
  }
}

@Controller("api/admin/portfolio")
@UseGuards(AdminKeyGuard)
export class AdminPortfolioController {
  constructor(private readonly portfolio: PortfolioService) {}

  @Get()
  listAll() {
    return this.portfolio.listAll();
  }

  @Post()
  create(@Body() dto: CreateCaseDto) {
    return this.portfolio.create(dto);
  }

  @Put(":id")
  update(@Param("id") id: string, @Body() dto: UpdateCaseDto) {
    return this.portfolio.update(id, dto);
  }

  @Delete(":id")
  remove(@Param("id") id: string) {
    return this.portfolio.remove(id);
  }
}
