# Detail Design

## Sheet: Header

| Mục | Nội dung |
| --- | --- |
| Tên dự án | Enterprise Construction Intelligence Platform (ECIP) - Phase 1 |
| Khách hàng | Tổng Công ty Hạ tầng ABC |
| Phạm vi triển khai | Thiết kế chi tiết semantic model, dashboard, KPI, RLS cho 20 dự án xây dựng; dùng trực tiếp cho đội developer triển khai. |
| Nguồn dữ liệu chính | SQL Server: ERP, PMIS, Procurement, Cost Control, Identity |
| Công nghệ sử dụng | SQL Server 2022, SSIS, Power Query M, DAX, XMLA Endpoint, Power BI Service |
| Phiên bản tài liệu | v1.0 - Detail Design |
| Người tạo / Ngày tạo | Senior BI Solution Architect / 2026-02-10 |
| Tiêu chuẩn phát triển | Naming: Fact*/Dim*; DateKey dạng YYYYMMDD; model star schema |

## Sheet: History

| Version | Ngày chỉnh sửa | Người chỉnh sửa | Mô tả thay đổi |
| --- | --- | --- | --- |
| v0.1 | 2026-01-18 | BI Architect | Khởi tạo phạm vi chi tiết mô hình dữ liệu. |
| v0.4 | 2026-01-30 | Data Engineer Lead | Bổ sung mapping source-to-semantic cho module vật tư và chi phí. |
| v0.7 | 2026-02-05 | Power BI Lead | Thiết kế dashboard layout và visual specification. |
| v0.9 | 2026-02-08 | Security Architect | Bổ sung role matrix và hướng dẫn RLS. |
| v1.0 | 2026-02-10 | Senior BI Solution Architect | Phát hành tài liệu detail cho triển khai. |

## Sheet: Overview

| Hạng mục | Mô tả chi tiết |
| --- | --- |
| Kiến trúc end-to-end | SQL Server OLTP -> SSIS ETL -> DW_Raw -> DW_Clean -> DW_Semantic (star schema) -> Power BI Dataset -> Power BI App. |
| Luồng dữ liệu | Dimension full-load 01:00 hằng ngày; fact incremental mỗi 2 giờ theo watermark LastUpdatedDatetime; refresh dataset 06/09/12/15/18/21h. |
| Phân tầng Raw | Giữ dữ liệu gần nguồn + ETLBatchID + ExtractedAtUTC để audit/replay. |
| Phân tầng Clean | Chuẩn hóa UOM, mã master data, chuẩn email UPN, xử lý duplicate business key. |
| Phân tầng Semantic | Star schema surrogate key int, quan hệ single-direction, ưu tiên measure để tối ưu model size. |
| ASCII architecture | [SQL Server OLTP]<br> ERP \| PMIS \| Procurement \| Cost \| Identity<br>                \|<br>          [SSIS Orchestration]<br>                \|<br>      [DW_Raw] -> [DW_Clean] -> [DW_Semantic]<br>                               \|<br>                    [Power BI Dataset]<br>                               \|<br>         [Executive][Material][Cost][Progress]<br>                               \|<br>                 [Power BI Service + RLS] |

## Sheet: Modules

| Module ID | Subject Area | Mục tiêu nghiệp vụ | Persona chính | Input dataset (SQL) | Output dashboard | KPI trọng tâm | Tần suất refresh | SLA |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| M01 | Material Management | Kiểm soát tiêu thụ vật tư theo định mức BOM và hao hụt theo nhà thầu/site. | Project Manager; Site Engineer; Procurement | MaterialMaster, MaterialIssueLine, MaterialReturnLine, BOMNorm | Material Consumption Control | Total Material Qty; Overuse %; Return Rate | 2 giờ/lần | Freshness <= 2h |
| M02 | Construction Progress | So sánh baseline vs actual theo work package/milestone và cảnh báo delay risk. | Planning Engineer; PM | BaselineSchedule, ProgressDaily, WorkPackagePlan | Progress & Delay Risk | Planned vs Actual %; Delay Days; SPI | 2 giờ/lần | Freshness <= 2h |
| M03 | Cost & Budget | Giám sát chi phí thực tế, ngân sách, cam kết chi và change order. | Finance Controller; PM; PMO | CostLedger, BudgetBaseline, CommitmentLedger, ChangeOrder | Cost vs Budget Deep Dive | Actual Cost; Budget Variance %; CPI | 2 giờ/lần | Freshness <= 2h |
| M04 | Contractor Performance | Đánh giá năng suất và tuân thủ SLA nhà thầu. | Contract Manager; PMO | ContractorMaster, ContractorKPI, DeliveryPerformance | Contractor Scorecard | Productivity Index; On-time Delivery % | Ngày | Daily 06:00 |
| M05 | Acceptance & Billing | Đối soát khối lượng nghiệm thu và thanh toán theo đợt. | QS; Site Engineer; Finance | AcceptanceMinutes, BillingProgress, PaymentCertificate | Acceptance & Billing Tracker | Accepted Qty; Pending Billing Amount | Ngày | Daily 06:00 |

## Sheet: DashboardCatalog

| Dashboard | Trang | Mục tiêu | Người dùng | Layout tổng quan | Mockup ASCII | Insight hành động |
| --- | --- | --- | --- | --- | --- | --- |
| Executive Portfolio Overview | Portfolio Summary | Bức tranh tổng quan ngân sách + tiến độ + rủi ro ở cấp portfolio. | CEO, COO, PMO Director | Row1 KPI x6; Row2-left column actual vs budget; Row2-right line cashflow; Row3 matrix overspend. | [KPI1][KPI2][KPI3][KPI4][KPI5][KPI6]<br>[Actual vs Budget] [Cashflow]<br>[Matrix Overspend] | Ưu tiên dự án Variance% > 10% và SPI < 0.95. |
| Material Consumption Control | Material Deep Dive | Theo dõi tiêu thụ vật tư theo loại, dự án, nhà thầu, định mức. | Project Manager, Site Engineer | Top KPI x4; donut material mix; stacked column theo dự án; heatmap overuse; table drillthrough. | [KPI x4]<br>[Donut] [Stacked Column] [Heatmap]<br>[Transaction Table] | Khoanh vùng contractor/work package gây overuse. |
| Cost vs Budget Deep Dive | Cost Analysis | Phân tích chênh lệch ngân sách theo category, contractor, timeline. | Finance Controller, PM | Top KPI; waterfall variance; bar theo category; treemap contractor; matrix drill path. | [KPI]<br>[Waterfall] [Bar]<br>[Treemap]<br>[Matrix Drilldown] | Xác định cost bucket cần cắt giảm. |
| Progress & Delay Risk | Schedule Monitoring | Giám sát tiến độ và dự báo trễ milestone. | Planning Engineer, PM | Top KPI; line planned vs actual; risk matrix; milestone table có conditional format. | [KPI]<br>[Trend Line] [Risk Matrix]<br>[Milestone Table] | Ưu tiên hạng mục delay > 7 ngày và risk score cao. |

## Sheet: DashboardLayoutSpec

| Dashboard | Page | Visual ID | Visual Type | X | Y | W | H | Field Binding | Visual-level Filter | Interaction/Drill | Ghi chú triển khai |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Executive Portfolio Overview | Portfolio Summary | V01 | Card | 20 | 20 | 180 | 80 | [Budget Cost] | Year=Current | Cross-highlight | KPI ngân sách |
| Executive Portfolio Overview | Portfolio Summary | V02 | Card | 220 | 20 | 180 | 80 | [Actual Cost] | Year=Current | Cross-highlight | KPI thực chi |
| Executive Portfolio Overview | Portfolio Summary | V03 | Card | 420 | 20 | 180 | 80 | [Budget Variance %] | Year=Current | Cross-highlight | KPI chênh lệch % |
| Executive Portfolio Overview | Portfolio Summary | V04 | Column | 20 | 130 | 700 | 260 | Axis:Project; Value:[Actual Cost],[Budget Cost] | TopN15 theo Actual Cost | Select project filters matrix | So sánh actual vs budget |
| Executive Portfolio Overview | Portfolio Summary | V05 | Line | 740 | 130 | 580 | 260 | Axis:Month; Value:[Actual Cost] | Last 18 months | Select month filters matrix | Xu hướng dòng tiền |
| Executive Portfolio Overview | Portfolio Summary | V06 | Matrix | 20 | 410 | 1300 | 280 | Rows:Project; Cols:CostCategory; Values:[Budget Variance] | [Budget Variance %] > 0 | Drilldown enabled | Top overspend |
| Material Consumption Control | Material Deep Dive | V03 | Donut | 20 | 120 | 360 | 260 | Legend:MaterialGroup; Value:[Total Material Quantity] | Exclude UNCLASSIFIED | Select group filters table | Tỷ trọng vật tư |
| Material Consumption Control | Material Deep Dive | V05 | Heatmap | 940 | 120 | 380 | 260 | X:Contractor; Y:WorkPackage; Value:[Material Overuse %] | Overuse% > 0 | Select cell drills table | Điểm nóng overuse |
| Cost vs Budget Deep Dive | Cost Analysis | V01 | Waterfall | 20 | 120 | 700 | 270 | Category:CostDriver; Y:[Budget Variance] | Year=selected | Select bar filters matrix | Variance bridge |
| Cost vs Budget Deep Dive | Cost Analysis | V04 | Matrix | 20 | 410 | 1300 | 280 | Rows:Project->Category->Contractor; Values:Budget,Actual,Variance% | No filter | Full drill path | Bảng đối soát |
| Progress & Delay Risk | Schedule Monitoring | V01 | Line | 20 | 120 | 720 | 260 | Axis:Week; Values:[Planned Progress %],[Actual Progress %] | Last 26 weeks | Select week filters milestones | Xu hướng tiến độ |
| Progress & Delay Risk | Schedule Monitoring | V03 | Table | 20 | 400 | 1300 | 290 | Milestone,PlannedDate,ForecastDate,DelayDays,Owner | DelayDays >= 3 | Conditional format by DelayDays | Milestone cảnh báo |

## Sheet: KPI

| KPI Code | KPI Name | Business Definition | DAX Logic | Unit | Granularity | Threshold | Owner | Validation Rule |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| KPI-01 | Total Material Quantity | Tổng khối lượng vật tư xuất dùng ròng. | Total Material Quantity = SUMX(FactMaterialConsumption, FactMaterialConsumption[IssuedQty]-FactMaterialConsumption[ReturnQty]) | Tấn/m3/cây | Project-Material-Date | MoM > +15%: Yellow; >+25%: Red | Procurement Lead | Đối soát tổng theo phiếu xuất-trả |
| KPI-02 | Material Overuse % | Tỷ lệ vượt định mức BOM. | Material Overuse % = DIVIDE([OverNorm Quantity], [Norm Quantity]) | % | Project-WorkPackage-Material | >10% Red | Site Engineering Manager | NormQty=0 thì BLANK và log DQ |
| KPI-03 | Actual Cost | Tổng chi phí thực tế. | Actual Cost = SUM(FactProjectCost[ActualAmount]) | VND | Project-Date-Category | Theo baseline dự án | Finance Controller | Đối soát CostLedger |
| KPI-04 | Budget Cost | Tổng ngân sách approved baseline. | Budget Cost = SUM(FactProjectCost[BudgetAmount]) | VND | Project-Date-Category | - | PMO Cost Team | Chỉ lấy baseline latest approved |
| KPI-05 | Budget Variance % | Tỷ lệ vượt/tiết kiệm ngân sách. | Budget Variance % = DIVIDE([Actual Cost]-[Budget Cost], [Budget Cost]) | % | Project-Date | >5% Yellow; >10% Red | PMO Director | Budget=0 thì BLANK |
| KPI-08 | SPI | Schedule Performance Index. | SPI = DIVIDE([Earned Value], [Planned Value]) | Index | Project-Week | <0.95 Red | PM | Đồng nhất kỳ EV/PV |
| KPI-09 | CPI | Cost Performance Index. | CPI = DIVIDE([Earned Value], [Actual Cost]) | Index | Project-Month | <0.95 Red | Finance PM | Actual Cost=0 thì BLANK |
| KPI-10 | Delay Days | Số ngày trễ tiến độ dự báo. | Delay Days = MAX(FactProgressTracking[DelayDays]) | Ngày | Project-Milestone | >7 Red | Planning Engineer | Delay âm ép về 0 tại ETL |

## Sheet: DataModel

| Table | Column | Data Type | Key Type | Nullable | Business Meaning | Rule / Note |
| --- | --- | --- | --- | --- | --- | --- |
| FactMaterialConsumption | MaterialTxnKey | bigint | PK | No | Khóa surrogate giao dịch vật tư | Generated in DW |
| FactMaterialConsumption | ProjectKey | int | FK->DimProject | No | Liên kết dự án | Lookup by ProjectCode |
| FactMaterialConsumption | MaterialKey | int | FK->DimMaterial | No | Liên kết vật tư | Lookup by MaterialCode |
| FactMaterialConsumption | ContractorKey | int | FK->DimContractor | Yes | Liên kết nhà thầu | Unknown=-1 |
| FactMaterialConsumption | DateKey | int | FK->DimDate | No | Ngày phát sinh | YYYYMMDD |
| FactMaterialConsumption | WorkPackageKey | int | FK->DimWorkPackage | Yes | Gói công việc | Unknown=-1 |
| FactMaterialConsumption | IssuedQty | decimal(18,3) | Measure | No | Khối lượng xuất | >=0 |
| FactMaterialConsumption | ReturnQty | decimal(18,3) | Measure | No | Khối lượng trả | >=0 |
| FactMaterialConsumption | NetQty | decimal(18,3) | Measure | No | IssuedQty - ReturnQty | Computed ETL |
| FactMaterialConsumption | ActualCost | decimal(18,2) | Measure | No | Chi phí vật tư thực tế | NetQty * UnitPrice |
| FactMaterialConsumption | NormQty | decimal(18,3) | Measure | Yes | Định mức BOM | Join BOMNorm |
| FactMaterialConsumption | OverNormQty | decimal(18,3) | Measure | Yes | Khối lượng vượt định mức | Max(0, Net-Norm) |
| FactMaterialConsumption | SourceDocNo | nvarchar(50) | Degenerate | Yes | Số chứng từ nguồn | Dùng drillthrough |
| FactMaterialConsumption | LastUpdatedDatetime | datetime2 | Audit | No | Watermark incremental | UTC |
| FactProjectCost | CostTxnKey | bigint | PK | No | Khóa surrogate giao dịch chi phí | Generated in DW |
| FactProjectCost | ProjectKey | int | FK->DimProject | No | Liên kết dự án | Lookup |
| FactProjectCost | ContractorKey | int | FK->DimContractor | Yes | Liên kết nhà thầu | Unknown=-1 |
| FactProjectCost | DateKey | int | FK->DimDate | No | Ngày hạch toán | YYYYMMDD |
| FactProjectCost | CostCategoryKey | int | FK->DimCostCategory | No | Nhóm chi phí | Lookup |
| FactProjectCost | BudgetAmount | decimal(18,2) | Measure | No | Ngân sách baseline | Latest approved |
| FactProjectCost | ActualAmount | decimal(18,2) | Measure | No | Chi phí thực tế | Exclude reversal |
| FactProjectCost | CommittedAmount | decimal(18,2) | Measure | Yes | Chi phí cam kết | PO/Contract |
| FactProjectCost | ChangeOrderAmount | decimal(18,2) | Measure | Yes | Giá trị phát sinh | Approved CO only |
| FactProjectCost | PaymentAmount | decimal(18,2) | Measure | Yes | Đã thanh toán | Paid status |
| FactProjectCost | CurrencyCode | nvarchar(10) | Attribute | No | Mã tiền tệ nguồn | Convert về VND |
| FactProjectCost | LastUpdatedDatetime | datetime2 | Audit | No | Watermark incremental | UTC |
| FactProgressTracking | ProgressTxnKey | bigint | PK | No | Khóa surrogate giao dịch tiến độ | Generated in DW |
| FactProgressTracking | ProjectKey | int | FK->DimProject | No | Liên kết dự án | Lookup |
| FactProgressTracking | DateKey | int | FK->DimDate | No | Ngày báo cáo | YYYYMMDD |
| FactProgressTracking | WorkPackageKey | int | FK->DimWorkPackage | No | Liên kết gói công việc | Lookup |
| FactProgressTracking | ContractorKey | int | FK->DimContractor | Yes | Nhà thầu thực hiện | Unknown=-1 |
| FactProgressTracking | PlannedQty | decimal(18,3) | Measure | No | Sản lượng kế hoạch | >=0 |
| FactProgressTracking | ActualCompletedQty | decimal(18,3) | Measure | No | Sản lượng hoàn thành thực tế | >=0 |
| FactProgressTracking | BaselineQty | decimal(18,3) | Measure | No | Khối lượng baseline | >=0 |
| FactProgressTracking | EarnedValue | decimal(18,2) | Measure | Yes | Giá trị EV | From baseline cost |
| FactProgressTracking | PlannedValue | decimal(18,2) | Measure | Yes | Giá trị PV | From baseline cost |
| FactProgressTracking | DelayDays | int | Measure | Yes | Số ngày trễ dự báo | Max(0, forecast-plan) |
| FactProgressTracking | LaborHours | decimal(18,2) | Measure | Yes | Giờ công thực tế | For productivity |
| FactProgressTracking | LastUpdatedDatetime | datetime2 | Audit | No | Watermark incremental | UTC |
| DimProject | ProjectKey | int | PK | No | Khóa surrogate dự án | Identity |
| DimProject | ProjectCode | nvarchar(30) | BK | No | Mã dự án nghiệp vụ | Unique |
| DimProject | ProjectName | nvarchar(255) | Attribute | No | Tên dự án | - |
| DimProject | ProjectType | nvarchar(50) | Attribute | Yes | Loại dự án | Controlled list |
| DimProject | Region | nvarchar(50) | Attribute | Yes | Miền/vùng | North/Central/South |
| DimProject | Status | nvarchar(30) | Attribute | No | Trạng thái dự án | Active/Closing/Closed |
| DimProject | ProjectManagerUPN | nvarchar(255) | Attribute | Yes | UPN quản lý dự án | For RLS |
| DimMaterial | MaterialKey | int | PK | No | Khóa surrogate vật tư | Identity |
| DimMaterial | MaterialCode | nvarchar(50) | BK | No | Mã vật tư | Unique |
| DimMaterial | MaterialName | nvarchar(255) | Attribute | No | Tên vật tư | - |
| DimMaterial | MaterialGroup | nvarchar(100) | Attribute | No | Nhóm vật tư | Standardized |
| DimMaterial | Unit | nvarchar(20) | Attribute | No | Đơn vị chuẩn | kg/tấn/m3 |
| DimMaterial | StandardUnitCost | decimal(18,2) | Attribute | Yes | Đơn giá chuẩn | VND |
| DimContractor | ContractorKey | int | PK | No | Khóa surrogate nhà thầu | Identity |
| DimContractor | ContractorCode | nvarchar(30) | BK | No | Mã nhà thầu | Unique |
| DimContractor | ContractorName | nvarchar(255) | Attribute | No | Tên nhà thầu | - |
| DimContractor | ContractorType | nvarchar(50) | Attribute | Yes | Main/Sub/Supplier | Controlled list |
| DimContractor | CompanyCode | nvarchar(30) | Attribute | Yes | Mã công ty | For RLS |
| DimDate | DateKey | int | PK | No | Khóa ngày YYYYMMDD | Calendar table |
| DimDate | FullDate | date | Attribute | No | Ngày thực | - |
| DimDate | MonthNo | tinyint | Attribute | No | Tháng | 1-12 |
| DimDate | QuarterNo | tinyint | Attribute | No | Quý | 1-4 |
| DimDate | YearNo | smallint | Attribute | No | Năm | YYYY |
| DimWorkPackage | WorkPackageKey | int | PK | No | Khóa surrogate gói công việc | Identity |
| DimWorkPackage | WorkPackageCode | nvarchar(40) | BK | No | Mã gói công việc | Unique per project |
| DimWorkPackage | WorkPackageName | nvarchar(255) | Attribute | No | Tên gói công việc | - |
| DimWorkPackage | Discipline | nvarchar(50) | Attribute | Yes | Civil/MEP/Structure | Controlled list |
| DimCostCategory | CostCategoryKey | int | PK | No | Khóa surrogate nhóm chi phí | Identity |
| DimCostCategory | CostCategoryCode | nvarchar(30) | BK | No | Mã nhóm chi phí | Unique |
| DimCostCategory | CostCategoryName | nvarchar(255) | Attribute | No | Tên nhóm chi phí | - |
| DimCostCategory | ParentCategory | nvarchar(100) | Attribute | Yes | Nhóm cha | Hierarchy |
| SecurityUserProject | UserUPN | nvarchar(255) | Security Key | No | UPN người dùng | Lowercase |
| SecurityUserProject | ProjectKey | int | Security FK->DimProject | No | Dự án được cấp quyền | Bridge table |
| SecurityUserProject | CompanyCode | nvarchar(30) | Security Attribute | Yes | Đơn vị/nhà thầu | For contractor role |
| SecurityUserProject | RoleName | nvarchar(30) | Security Attribute | No | Admin/ProjectManager/SiteEngineer | Controlled list |
| SecurityUserProject | IsActive | bit | Security Attribute | No | Hiệu lực quyền | 1 active |

## Sheet: ModelRelationships

| From Table | From Column | To Table | To Column | Cardinality | Cross Filter | Active | Mục đích |
| --- | --- | --- | --- | --- | --- | --- | --- |
| FactMaterialConsumption | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Phân tích vật tư theo dự án |
| FactMaterialConsumption | MaterialKey | DimMaterial | MaterialKey | Many-to-One | Single | Yes | Phân tích theo nhóm vật liệu |
| FactMaterialConsumption | ContractorKey | DimContractor | ContractorKey | Many-to-One | Single | Yes | Phân tích theo nhà thầu |
| FactMaterialConsumption | DateKey | DimDate | DateKey | Many-to-One | Single | Yes | Phân tích theo thời gian |
| FactMaterialConsumption | WorkPackageKey | DimWorkPackage | WorkPackageKey | Many-to-One | Single | Yes | Phân tích theo gói công việc |
| FactProjectCost | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Chi phí theo dự án |
| FactProjectCost | CostCategoryKey | DimCostCategory | CostCategoryKey | Many-to-One | Single | Yes | Chi phí theo danh mục |
| FactProjectCost | ContractorKey | DimContractor | ContractorKey | Many-to-One | Single | Yes | Chi phí theo nhà thầu |
| FactProjectCost | DateKey | DimDate | DateKey | Many-to-One | Single | Yes | Chi phí theo thời gian |
| FactProgressTracking | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Tiến độ theo dự án |
| FactProgressTracking | WorkPackageKey | DimWorkPackage | WorkPackageKey | Many-to-One | Single | Yes | Tiến độ theo gói công việc |
| FactProgressTracking | ContractorKey | DimContractor | ContractorKey | Many-to-One | Single | Yes | Tiến độ theo nhà thầu |
| FactProgressTracking | DateKey | DimDate | DateKey | Many-to-One | Single | Yes | Tiến độ theo thời gian |
| SecurityUserProject | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Bridge bảo mật RLS theo dự án |

## Sheet: SourceMapping

| Source System | Source Table | Source Column | Power BI Table | Power BI Field | Data Type | Transformation |
| --- | --- | --- | --- | --- | --- | --- |
| SQLServer-ERP | dbo.ProjectMaster | ProjectCode | DimProject | ProjectCode | nvarchar(30) | TRIM + UPPER; reject null |
| SQLServer-ERP | dbo.ProjectMaster | ProjectName | DimProject | ProjectName | nvarchar(255) | Text.Clean + collapse spaces |
| SQLServer-ERP | dbo.ProjectMaster | ProjectType | DimProject | ProjectType | nvarchar(50) | Map via RefProjectType |
| SQLServer-ERP | dbo.ProjectMaster | RegionCode | DimProject | Region | nvarchar(50) | Join RefRegion |
| SQLServer-ERP | dbo.ProjectMaster | ProjectManagerEmail | DimProject | ProjectManagerUPN | nvarchar(255) | LOWER(TRIM(email)) |
| SQLServer-ERP | dbo.ProjectMaster | CompanyCode | DimProject | CompanyCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialCode | DimMaterial | MaterialCode | nvarchar(50) | TRIM |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialName | DimMaterial | MaterialName | nvarchar(255) | Text.Clean |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialGroupCode | DimMaterial | MaterialGroup | nvarchar(100) | Join RefMaterialGroup |
| SQLServer-Procurement | dbo.MaterialMaster | BaseUOM | DimMaterial | Unit | nvarchar(20) | Map to standard UOM |
| SQLServer-Procurement | dbo.MaterialMaster | StdUnitCost | DimMaterial | StandardUnitCost | decimal(18,2) | Cast decimal; negative->0 |
| SQLServer-Engineering | dbo.BOMNorm | NormPerUnitWork | DimMaterial | NormPerUnitWork | decimal(18,4) | Latest approved by EffectiveDate |
| SQLServer-PMIS | dbo.ContractorMaster | ContractorCode | DimContractor | ContractorCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-PMIS | dbo.ContractorMaster | ContractorName | DimContractor | ContractorName | nvarchar(255) | Text.Clean |
| SQLServer-PMIS | dbo.ContractorMaster | ContractorType | DimContractor | ContractorType | nvarchar(50) | Map controlled list |
| SQLServer-PMIS | dbo.ContractorMaster | CompanyCode | DimContractor | CompanyCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-PMIS | dbo.ContractorScore | PerformanceTier | DimContractor | PerformanceTier | nvarchar(20) | Latest score snapshot |
| SQLServer-PMIS | dbo.WorkPackagePlan | WorkPackageCode | DimWorkPackage | WorkPackageCode | nvarchar(40) | TRIM |
| SQLServer-PMIS | dbo.WorkPackagePlan | WorkPackageName | DimWorkPackage | WorkPackageName | nvarchar(255) | Text.Clean |
| SQLServer-PMIS | dbo.WorkPackagePlan | DisciplineCode | DimWorkPackage | Discipline | nvarchar(50) | Join RefDiscipline |
| SQLServer-PMIS | dbo.WorkPackagePlan | PlannedStartDate | DimWorkPackage | PlannedStartDateKey | int | Convert to DateKey |
| SQLServer-PMIS | dbo.WorkPackagePlan | PlannedFinishDate | DimWorkPackage | PlannedFinishDateKey | int | Convert to DateKey |
| SQLServer-Cost | dbo.CostCategoryMaster | CostCategoryCode | DimCostCategory | CostCategoryCode | nvarchar(30) | TRIM |
| SQLServer-Cost | dbo.CostCategoryMaster | CostCategoryName | DimCostCategory | CostCategoryName | nvarchar(255) | Text.Clean |
| SQLServer-Cost | dbo.CostCategoryMaster | CostType | DimCostCategory | CostTypeDirectIndirect | nvarchar(20) | Map Direct/Indirect |
| SQLServer-Cost | dbo.CostCategoryMaster | ParentCategory | DimCostCategory | ParentCategory | nvarchar(100) | Hierarchy flatten |
| SQLServer-Procurement | dbo.MaterialIssueLine | IssueTxnID | FactMaterialConsumption | MaterialTxnKey | bigint | Hash surrogate key |
| SQLServer-Procurement | dbo.MaterialIssueLine | ProjectCode | FactMaterialConsumption | ProjectKey | int | Lookup DimProject |
| SQLServer-Procurement | dbo.MaterialIssueLine | MaterialCode | FactMaterialConsumption | MaterialKey | int | Lookup DimMaterial |
| SQLServer-Procurement | dbo.MaterialIssueLine | ContractorCode | FactMaterialConsumption | ContractorKey | int | Lookup DimContractor |
| SQLServer-Procurement | dbo.MaterialIssueLine | IssueDate | FactMaterialConsumption | DateKey | int | Convert to DateKey |
| SQLServer-Procurement | dbo.MaterialIssueLine | WorkPackageCode | FactMaterialConsumption | WorkPackageKey | int | Lookup DimWorkPackage |
| SQLServer-Procurement | dbo.MaterialIssueLine | IssuedQty | FactMaterialConsumption | IssuedQty | decimal(18,3) | Cast decimal; null->0 |
| SQLServer-Procurement | dbo.MaterialReturnLine | ReturnQty | FactMaterialConsumption | ReturnQty | decimal(18,3) | Aggregate by txn; null->0 |
| SQLServer-Engineering | dbo.BOMNorm | NormQty | FactMaterialConsumption | NormQty | decimal(18,3) | Join by Project+WorkPackage+Material |
| SQLServer-Procurement | dbo.MaterialIssueLine | DocNo | FactMaterialConsumption | SourceDocNo | nvarchar(50) | TRIM |
| SQLServer-Procurement | dbo.MaterialIssueLine | LastUpdated | FactMaterialConsumption | LastUpdatedDatetime | datetime2 | UTC normalize |
| SQLServer-Cost | dbo.CostLedger | CostTxnID | FactProjectCost | CostTxnKey | bigint | Hash surrogate key |
| SQLServer-Cost | dbo.CostLedger | ProjectCode | FactProjectCost | ProjectKey | int | Lookup DimProject |
| SQLServer-Cost | dbo.CostLedger | ContractorCode | FactProjectCost | ContractorKey | int | Lookup DimContractor |
| SQLServer-Cost | dbo.CostLedger | PostingDate | FactProjectCost | DateKey | int | Convert to DateKey |
| SQLServer-Cost | dbo.CostLedger | CostCategoryCode | FactProjectCost | CostCategoryKey | int | Lookup DimCostCategory |
| SQLServer-Cost | dbo.BudgetBaseline | BudgetAmount | FactProjectCost | BudgetAmount | decimal(18,2) | Latest approved baseline only |
| SQLServer-Cost | dbo.CostLedger | ActualAmount | FactProjectCost | ActualAmount | decimal(18,2) | Exclude reversal entries |
| SQLServer-Cost | dbo.CommitmentLedger | CommittedAmount | FactProjectCost | CommittedAmount | decimal(18,2) | Aggregate by project/date/category |
| SQLServer-Cost | dbo.ChangeOrder | ChangeOrderAmount | FactProjectCost | ChangeOrderAmount | decimal(18,2) | Approved status only |
| SQLServer-Cost | dbo.PaymentCertificate | PaymentAmount | FactProjectCost | PaymentAmount | decimal(18,2) | Paid status only |
| SQLServer-Cost | dbo.CostLedger | CurrencyCode | FactProjectCost | CurrencyCode | nvarchar(10) | TRIM + UPPER |
| SQLServer-Cost | dbo.CostLedger | LastUpdated | FactProjectCost | LastUpdatedDatetime | datetime2 | UTC normalize |
| SQLServer-PMIS | dbo.ProgressDaily | ProgressTxnID | FactProgressTracking | ProgressTxnKey | bigint | Hash surrogate key |
| SQLServer-PMIS | dbo.ProgressDaily | ProjectCode | FactProgressTracking | ProjectKey | int | Lookup DimProject |
| SQLServer-PMIS | dbo.ProgressDaily | WorkPackageCode | FactProgressTracking | WorkPackageKey | int | Lookup DimWorkPackage |
| SQLServer-PMIS | dbo.ProgressDaily | ContractorCode | FactProgressTracking | ContractorKey | int | Lookup DimContractor |
| SQLServer-PMIS | dbo.ProgressDaily | ReportDate | FactProgressTracking | DateKey | int | Convert to DateKey |
| SQLServer-PMIS | dbo.ProgressDaily | PlannedQty | FactProgressTracking | PlannedQty | decimal(18,3) | Cast decimal |
| SQLServer-PMIS | dbo.ProgressDaily | ActualCompletedQty | FactProgressTracking | ActualCompletedQty | decimal(18,3) | Cast decimal |
| SQLServer-PMIS | dbo.ProgressDaily | BaselineQty | FactProgressTracking | BaselineQty | decimal(18,3) | Lookup by WorkPackageKey |
| SQLServer-PMIS | dbo.ProgressDaily | DelayDays | FactProgressTracking | DelayDays | int | If negative then 0 |
| SQLServer-PMIS | dbo.ProgressDaily | LaborHours | FactProgressTracking | LaborHours | decimal(18,2) | Null->0 |
| SQLServer-PMIS | dbo.ProgressDaily | LastUpdated | FactProgressTracking | LastUpdatedDatetime | datetime2 | UTC normalize |
| SQLServer-Identity | dbo.UserProjectAccess | UserEmail | SecurityUserProject | UserUPN | nvarchar(255) | LOWER(TRIM(email)) |
| SQLServer-Identity | dbo.UserProjectAccess | ProjectCode | SecurityUserProject | ProjectKey | int | Lookup DimProject |
| SQLServer-Identity | dbo.UserProjectAccess | CompanyCode | SecurityUserProject | CompanyCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-Identity | dbo.UserProjectAccess | RoleName | SecurityUserProject | RoleName | nvarchar(30) | Map approved role list |
| SQLServer-Identity | dbo.UserProjectAccess | IsActive | SecurityUserProject | IsActive | bit | Cast bit |

## Sheet: DAXLogic

| Loại | Tên logic | Công thức DAX đầy đủ | Giải thích | Test case |
| --- | --- | --- | --- | --- |
| Measure | Total Material Quantity | Total Material Quantity =<br>SUMX(<br>    FactMaterialConsumption,<br>    FactMaterialConsumption[IssuedQty] - FactMaterialConsumption[ReturnQty]<br>) | Tổng khối lượng vật tư ròng trong filter context. | Đối chiếu với tổng NetQty cùng bộ lọc. |
| Measure | Norm Quantity | Norm Quantity =<br>SUM ( FactMaterialConsumption[NormQty] ) | Tổng định mức vật tư theo BOM approved. | Nếu thiếu BOM cần log DQ. |
| Measure | OverNorm Quantity | OverNorm Quantity =<br>SUMX(<br>    FactMaterialConsumption,<br>    MAX ( FactMaterialConsumption[NetQty] - FactMaterialConsumption[NormQty], 0 )<br>) | Khối lượng vượt định mức transaction-level. | Giá trị không được âm. |
| Measure | Material Overuse % | Material Overuse % =<br>DIVIDE ( [OverNorm Quantity], [Norm Quantity] ) | Tỷ lệ overuse để cảnh báo đỏ >10%. | Norm=0 trả BLANK. |
| Measure | Actual Cost | Actual Cost =<br>SUM ( FactProjectCost[ActualAmount] ) | Tổng chi phí thực tế. | Đối soát CostLedger theo ngày. |
| Measure | Budget Cost | Budget Cost =<br>SUM ( FactProjectCost[BudgetAmount] ) | Tổng ngân sách baseline approved. | Chỉ lấy baseline latest approved. |
| Measure | Budget Variance | Budget Variance =<br>[Actual Cost] - [Budget Cost] | Chênh lệch tuyệt đối actual vs budget. | Dương là vượt ngân sách. |
| Measure | Budget Variance % | Budget Variance % =<br>DIVIDE ( [Budget Variance], [Budget Cost] ) | Tỷ lệ vượt/tiết kiệm ngân sách. | Budget=0 trả BLANK. |
| Measure | Planned Progress % | Planned Progress % =<br>DIVIDE(<br>    SUM(FactProgressTracking[PlannedQty]),<br>    SUM(FactProgressTracking[BaselineQty])<br>) | Mức hoàn thành kế hoạch. | Kỳ vọng trong khoảng 0%-100%. |
| Measure | Actual Progress % | Actual Progress % =<br>VAR _progress = DIVIDE(<br>    SUM(FactProgressTracking[ActualCompletedQty]),<br>    SUM(FactProgressTracking[BaselineQty])<br>)<br>RETURN IF(_progress > 1, 1, _progress) | Mức hoàn thành thực tế, cap tối đa 100%. | Baseline=0 trả BLANK. |
| Measure | SPI | SPI =<br>DIVIDE ( [Earned Value], [Planned Value] ) | Schedule Performance Index. | SPI<0.95 cảnh báo đỏ. |
| Measure | CPI | CPI =<br>DIVIDE ( [Earned Value], [Actual Cost] ) | Cost Performance Index. | CPI<0.95 cảnh báo đỏ. |
| Measure | Rolling 3M Actual Cost | Rolling 3M Actual Cost =<br>CALCULATE(<br>    [Actual Cost],<br>    DATESINPERIOD(DimDate[FullDate], MAX(DimDate[FullDate]), -3, MONTH)<br>) | Xu hướng chi phí 3 tháng gần nhất. | So sánh trend theo từng dự án. |
| Measure | Delay Risk Level | Delay Risk Level =<br>VAR _delay = [Delay Days]<br>VAR _spi = [SPI]<br>RETURN<br>SWITCH(<br>    TRUE(),<br>    _delay >= 14 \|\| _spi < 0.9, "High",<br>    _delay >= 7 \|\| _spi < 0.95, "Medium",<br>    "Low"<br>) | Phân tầng mức rủi ro delay. | Kiểm tra biên tại delay=7 và 14. |
| Calculated Column | FactProjectCost[VarianceFlag] | VarianceFlag =<br>VAR _pct = DIVIDE(FactProjectCost[ActualAmount]-FactProjectCost[BudgetAmount], FactProjectCost[BudgetAmount])<br>RETURN<br>SWITCH(<br>    TRUE(),<br>    ISBLANK(_pct), "No Budget",<br>    _pct > 0.1, "Red",<br>    _pct > 0.05, "Yellow",<br>    "Green"<br>) | Phân loại màu cảnh báo transaction-level. | Dùng conditional formatting matrix. |

## Sheet: BusinessRules

| Rule ID | Phân hệ | Luật nghiệp vụ chi tiết | Điểm triển khai | Xử lý ngoại lệ | Data Owner |
| --- | --- | --- | --- | --- | --- |
| BR-01 | Material | Mã vật tư phải map MaterialGroup; không map gán UNCLASSIFIED và alert 08:00 mỗi ngày. | ETL SQL + Power Query | Vẫn load nhưng loại khỏi KPI chiến lược. | MDM Team |
| BR-02 | Material | NormQty lấy theo BOM approved mới nhất có EffectiveDate <= ngày giao dịch. | ETL SQL | Không có BOM thì Overuse KPI trả BLANK và log DQ. | Engineering Control |
| BR-03 | Project | Chỉ load dự án Status IN ('Active','Closing'); Closed giữ tối đa 24 tháng. | ETL SQL | Audit sâu dùng workspace archive. | PMO |
| BR-04 | Cost | ActualAmount loại bút toán reversal/cancelled theo trạng thái chứng từ. | ETL SQL | Reversal đến sau cutoff ghi adjustment kỳ kế tiếp. | Finance |
| BR-05 | Cost | Quy đổi currency về VND theo tỷ giá cuối tháng; thiếu rate dùng nearest previous. | Power Query + SQL | Thiếu rate >7 ngày đánh critical. | Treasury |
| BR-06 | Progress | DelayDays = max(0, ForecastFinishDate - PlannedFinishDate). | ETL SQL | Forecast null dùng RevisedFinishDate. | Planning Office |
| BR-07 | Progress | Actual Progress % cap 100% để tránh outlier do baseline cập nhật trễ. | DAX | Record >100% được log để PM xác nhận. | Planning Office |
| BR-08 | Contractor | Productivity Index chỉ tính khi LaborHours>0 và ActualCompletedQty>0. | DAX | Record không hợp lệ đưa vào trang Data Quality. | Contract Management |
| BR-09 | Security | User chỉ xem dự án mapping trong SecurityUserProject và IsActive=1. | RLS DAX | User không mapping sẽ không thấy dữ liệu. | IT Security |
| BR-10 | Governance | Khóa số liệu tháng vào T+3 18:00; sửa sau khóa cần approval ticket. | Process + SQL | Lưu audit trail DataCorrectionLog. | PMO + Data Governance |
| BR-11 | Dashboard | Executive dashboard chỉ hiển thị Top 15 dự án theo Actual Cost để tối ưu hiệu năng. | Visual Filter | Danh sách đầy đủ ở drillthrough. | BI Team |
| BR-12 | Quality | Đối soát KPI semantic vs source hằng ngày; sai lệch cho phép <=0.5%. | SQL Validation Job | Lệch >0.5% thì refresh fail + gửi alert. | Data Quality Team |

## Sheet: RLS

| Role | Bảng áp dụng filter | DAX Filter | Phạm vi truy cập | Thiết lập Power BI Service | Kịch bản kiểm thử |
| --- | --- | --- | --- | --- | --- |
| Admin | DimProject | TRUE() | Xem toàn bộ dữ liệu tất cả dự án. | Gán Azure AD group BI-Admins vào role Admin. | admin@abc.com phải thấy đủ 20 dự án. |
| Project Manager | SecurityUserProject | SecurityUserProject[UserUPN] = USERPRINCIPALNAME() && SecurityUserProject[RoleName] = "ProjectManager" && SecurityUserProject[IsActive] = TRUE() | Chỉ xem dữ liệu dự án được phân công. | Relationship SecurityUserProject[ProjectKey] -> DimProject[ProjectKey], single direction. | pm.north@abc.com chỉ thấy dự án miền Bắc được gán. |
| Site Engineer | SecurityUserProject | SecurityUserProject[UserUPN] = USERPRINCIPALNAME() && SecurityUserProject[RoleName] = "SiteEngineer" && SecurityUserProject[IsActive] = TRUE() | Xem vật tư + tiến độ site phụ trách; không xem dashboard chi phí tổng. | Tách app permission, không publish trang Cost Analysis cho role này. | site.hcm@abc.com không truy cập trang chi phí. |
| Contractor Viewer | DimContractor | DimContractor[CompanyCode] IN CALCULATETABLE(VALUES(SecurityUserProject[CompanyCode]), SecurityUserProject[UserUPN]=USERPRINCIPALNAME(), SecurityUserProject[RoleName]="ContractorViewer", SecurityUserProject[IsActive]=TRUE()) | Nhà thầu chỉ xem dữ liệu company code của mình. | Disable export underlying data với app external. | contractor.a@partner.com chỉ thấy CNT-A. |
