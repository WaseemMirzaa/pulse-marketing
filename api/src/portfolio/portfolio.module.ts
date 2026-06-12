import { Module } from "@nestjs/common";
import { PortfolioController, AdminPortfolioController } from "./portfolio.controller";
import { PortfolioService } from "./portfolio.service";

@Module({
  controllers: [PortfolioController, AdminPortfolioController],
  providers: [PortfolioService],
  exports: [PortfolioService],
})
export class PortfolioModule {}
